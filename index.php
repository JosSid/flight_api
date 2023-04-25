<?php

require 'flight/Flight.php';
# nos conectamos a la base de datos con el tipo de conexion PDO,con el usuario root y sin contraseña; 
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api','root',''));


Flight::route('GET /alumnos', function () {

    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos`");
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    
    Flight::json($datos);
});

Flight::route('POST /alumnos', function () {

    $nombre=(Flight::request()->data->nombre);
    $apellidos=(Flight::request()->data->apellidos);

    $sql="INSERT INTO alumnos (nombre, apellidos) VALUES (?,?)";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$apellidos);
    $sentencia->execute();
    
    Flight::jsonp(['Alumno agregado']);
});

Flight::start();


