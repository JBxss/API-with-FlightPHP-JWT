<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require 'vendor/autoload.php';

function getToken() {

    $headers = apache_request_headers();

    if (!isset($headers["Authorization"])) {
        Flight::halt(403, json_encode([
            "error" => "Unauthenticated Request",
            "status" => "error"
        ]));
    }

    $authorization = $headers["Authorization"];
    $authorizationArray = explode(" ", $authorization);
    $token = $authorizationArray[1];

    try {
        return JWT::decode($token, new Key("CONTRASEÑA_EJEMPLO", "HS256"));
    } catch (\Throwable $th) {
        Flight::halt(403, json_encode([
            "error" => $th->getMessage(),
            "status" => "error"
        ]));
    }

}

function validateToken() {
    $info = getToken();
    $db = Flight::db();
    $query = $db->prepare("SELECT * FROM tbl_usuarios WHERE id = :id");
    $query->execute([":id" => $info->data]);
    $rows = $query->fetchColumn();
    return $rows;
}

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api','root',''),
  function($db){
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }
);

Flight::route('GET /users', function(){

    $db = Flight::db();
    $query = $db->prepare("SELECT * FROM tbl_usuarios");
    $query->execute();
    $data = $query->fetchAll();

    $array = [];
    foreach ($data as $row) {
        $array[] = [
            "Id" => $row['id'],
            "Nombre" => $row['nombre'],
            "Email" => $row['correo'],
            "Contraseña" => $row['contraseña'],
            "Celular" => $row['telefono'],
            "Rol_Id" => $row['rol_id'],
            "Estado" => $row['status'],
        ];
    }
    
    Flight::json([
        "Total_Rows" => $query->rowCount(),
        "Rows" => $array
    ]);

});

Flight::route('GET /users/@id', function($id){

    $db = Flight::db();
    $query = $db->prepare("SELECT * FROM tbl_usuarios WHERE id = :id");
    $query->execute([":id" => $id]);
    $data = $query->fetch();


        $array = [
            "Id" => $data['id'],
            "Nombre" => $data['nombre'],
            "Email" => $data['correo'],
            "Contraseña" => $data['contraseña'],
            "Celular" => $data['telefono'],
            "Rol_Id" => $data['rol_id'],
            "Estado" => $data['status'],
        ];
  
    Flight::json($array);

});

Flight::route('POST /users', function(){

    if (!validateToken()) {
        Flight::halt(403, json_encode([
            "error" => "Unauthorized",
            "status" => "error"
        ]));
    }

    $db = Flight::db();
    $nombre = Flight::request()->data->nombre;
    $email = Flight::request()->data->correo;
    $pass = Flight::request()->data->contraseña;
    $telefono = Flight::request()->data->telefono;

    $query = $db->prepare("INSERT INTO tbl_usuarios (nombre, correo, contraseña, telefono) VALUES (:nombre, :email, :pass, :telefono)");

    $array = [
        "error" => "Hubo un error al agregar los registros, por favor verifica todos los campos",
        "status" => "error"
    ];

    if ($query->execute([":nombre" => $nombre, ":email" => $email, ":pass" => $pass, ":telefono" => $telefono])) {

        $array = [

            "data" => [
            "Id" => $db->lastInsertId(),
            "Nombre" => $nombre,
            "Email" => $email,
            "Contraseña" => $pass,
            "Celular" => $telefono
            ],

            "status" => "success" 
        ];
    };

    Flight::json($array);
});

Flight::route('PUT /users', function(){

    if (!validateToken()) {
        Flight::halt(403, json_encode([
            "error" => "Unauthorized",
            "status" => "error"
        ]));
    }

    $db = Flight::db();
    $id = Flight::request()->data->id;
    $nombre = Flight::request()->data->nombre;
    $email = Flight::request()->data->correo;
    $pass = Flight::request()->data->contraseña;
    $telefono = Flight::request()->data->telefono;

    $query = $db->prepare("UPDATE tbl_usuarios SET nombre = :nombre, correo = :email, contraseña = :pass, telefono = :telefono WHERE id = :id");

    $array = [
        "error" => "Hubo un error al agregar los registros, por favor verifica todos los campos",
        "status" => "error"
    ];

    if ($query->execute([":nombre" => $nombre, ":email" => $email, ":pass" => $pass, ":telefono" => $telefono, ":id" => $id])) {

        $array = [

            "data" => [
            "Id" => $id,
            "Nombre" => $nombre,
            "Email" => $email,
            "Contraseña" => $pass,
            "Celular" => $telefono
            ],

            "status" => "success" 
        ];
    };

    Flight::json($array);
});

Flight::route('DELETE /users', function(){

    if (!validateToken()) {
        Flight::halt(403, json_encode([
            "error" => "Unauthorized",
            "status" => "error"
        ]));
    }
    
    $db = Flight::db();
    $id = Flight::request()->data->id;

    $query = $db->prepare("DELETE from tbl_usuarios WHERE id = :id");

    $array = [
        "error" => "Hubo un error al agregar los registros, por favor verifica todos los campos",
        "status" => "error"
    ];

    if ($query->execute([":id" => $id])) {

        $array = [

            "data" => [
            "Id" => $id
            ],

            "status" => "success" 
        ];
    };

    Flight::json($array);
});

Flight::route('POST /auth', function(){

    $db = Flight::db();

    $email = Flight::request()->data->correo;
    $pass = Flight::request()->data->contraseña;
    $query = $db->prepare("SELECT * FROM tbl_usuarios WHERE correo = :email and contraseña = :pass");

    $array = [
        "error" => "Hubo un error no se pudo validar su identidad",
        "status" => "error"
    ];

    if ($query->execute([":email" => $email, ":pass" => $pass])) {
        
        $user = $query->fetch();
        $now = strtotime("now");
        $key = 'CONTRASEÑA_EJEMPLO';
        $payload = [
        'exp' => $now + 3600,
        'data' => $user['id']
        ];
    
        $jwt = JWT::encode($payload, $key, 'HS256');
        $array = ["token" => $jwt];
    };

    Flight::json($array);

});

Flight::start();