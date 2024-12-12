<?php

include_once '../php-librarys/db.php'

function crearProyecto($nombre, $descripcion, $id_usuario) {
    try {
        $conexion = openDb();

        // 1. Insertar el proyecto en la tabla `proyecto`
        $stmt = $conexion->prepare("INSERT INTO proyecto (nombre, descripcion) VALUES (:nombre, :descripcion)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();

        // 2. Obtener el ID del proyecto recién creado
        $id_proyecto = $conexion->lastInsertId();

        // 3. Insertar al usuario como Admin (id_rol = 2) en la tabla `participar`
        $stmt = $conexion->prepare("INSERT INTO participar (id_usuario, id_proyecto, id_rol) VALUES (:id_usuario, :id_proyecto, 2)");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_proyecto', $id_proyecto);
        $stmt->execute();

        closeDb();
        return $id_proyecto; // Retornar el ID del proyecto creado

    } catch (PDOException $e) {
        return errorMessage($e); // Manejar errores
    }
}