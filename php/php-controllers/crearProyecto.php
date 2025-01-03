<?php
include_once '../php-librarys/db.php';
include_once './projectController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    if (!empty($nombre) && !empty($descripcion)) {
        $proyectoCreado = crearProyecto($id_usuario, $nombre, $descripcion);
        if ($proyectoCreado) {
            echo "Proyecto guardado";  // Respuesta exitosa
        } else {
            echo "Error al crear el proyecto.";  // Error al crear el proyecto
        }
    } else {
        echo "Todos los campos son obligatorios.";  // Validación de campos vacíos
    }
}
?>
