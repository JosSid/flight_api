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

Flight::route('GET /alumnos/@id', function ($id) {
    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos` WHERE id=?");
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    $datos=$sentencia->fetch();
    
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

Flight::route('PUT /alumnos', function () {

    $id=(Flight::request()->data->id);
    $nombre=(Flight::request()->data->nombre);
    $apellidos=(Flight::request()->data->apellidos);

    $sql="UPDATE alumnos SET nombre=?, apellidos=? WHERE id=?";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(3,$id);
    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$apellidos);
    $sentencia->execute();
    
    Flight::jsonp(['Alumno Modificado']);
});

Flight::route('DELETE /alumnos', function () {

    $id=(Flight::request()->data->id);
    $sql="DELETE FROM alumnos WHERE id=?";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$id);
    $sentencia->execute();

    Flight::jsonp(['Alumno Borrado']);
});

Flight::start();


