<?php
require 'vendor/autoload.php';
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api','root',''));

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

Flight::start();