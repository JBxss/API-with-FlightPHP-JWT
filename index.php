<?php

require 'vendor/autoload.php';
require 'classes/Users.php';

$users = new Users();

Flight::route('GET /users', [$users, "SelectAll"]);
Flight::route('GET /users/@id', [$users, "SelectOne"]);
Flight::route('POST /users', [$users, "NewUser"]);
Flight::route('PUT /users', [$users, "UpdateUser"]);
Flight::route('DELETE /users', [$users, "DeleteUser"]);
Flight::route('POST /auth', [$users, "Authorization"]);

Flight::start();