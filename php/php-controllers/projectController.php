<?php
include_once '../php/php-librarys/db.php';
session_start();

// Crear un proyecto
function crearProyecto($id_usuario, $nombre, $descripcion)
{
    try {
        $conexion = openDb();

        // Crear el proyecto
        $stmtProyecto = $conexion->prepare("
            INSERT INTO proyecto (nombre, descripcion) VALUES (:nombre, :descripcion)
        ");
        $stmtProyecto->bindParam(':nombre', $nombre);
        $stmtProyecto->bindParam(':descripcion', $descripcion);
        $stmtProyecto->execute();

        $id_proyecto = $conexion->lastInsertId();

        // Asignar al usuario como administrador del proyecto
        $stmtRol = $conexion->prepare("
            INSERT INTO participar (id_usuario, id_proyecto, id_rol) VALUES (:id_usuario, :id_proyecto, 1)
        "); // Suponiendo que el rol "administrador" tiene id_rol = 1
        $stmtRol->bindParam(':id_usuario', $id_usuario);
        $stmtRol->bindParam(':id_proyecto', $id_proyecto);
        $stmtRol->execute();

        $conexion = closeDb();
        return true;
    } catch (PDOException $e) {
        return errorMessage($e);
    }
}

// Obtener los proyectos de un usuario donde es administrador
function obtenerProyectosPorUsuario($id_usuario)
{
    try {
        $conexion = openDb();
        $stmt = $conexion->prepare("
            SELECT p.* 
            FROM proyecto p
            JOIN participar pa ON p.id_proyecto = pa.id_proyecto
            WHERE pa.id_usuario = :id_usuario AND pa.id_rol = 1
        ");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conexion = closeDb();
        return $proyectos;
    } catch (PDOException $e) {
        return errorMessage($e);
    }
}

// Obtener los usuarios de un proyecto
function obtenerUsuariosPorProyecto($id_proyecto)
{
    try {
        $conexion = openDb();
        $stmt = $conexion->prepare("
            SELECT u.id_usuario, u.nombre, r.nombre AS rol
            FROM participar pa
            JOIN usuario u ON pa.id_usuario = u.id_usuario
            JOIN rol r ON pa.id_rol = r.id_rol
            WHERE pa.id_proyecto = :id_proyecto
        ");
        $stmt->bindParam(':id_proyecto', $id_proyecto);
        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conexion = closeDb();
        return $usuarios;
    } catch (PDOException $e) {
        return errorMessage($e);
    }
}
?>
