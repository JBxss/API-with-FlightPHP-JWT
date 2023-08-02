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

Flight::start();