<?php
include_once '../php-librarys/db.php'; // Conexión a la base de datos
include_once './userController.php';  // Funciones de usuario
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener credenciales del formulario
    $nombre = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($password)) {
        echo "El nombre de usuario y la contraseña son obligatorios.";
        exit;
    }

    // Verificar el usuario utilizando la función de userController.php
    $usuario = verificarUsuario($nombre, $password);

    if ($usuario) {
        // Si el usuario es válido, iniciar sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];

        // Opcional: obtener roles del usuario en proyectos
        $roles = obtenerRolesUsuario($usuario['id_usuario']);
        $_SESSION['roles'] = $roles;

        // Redirigir a la página principal
        header('Location: ../../html/proyectos.php');
        exit;
    } else {
        // Usuario o contraseña incorrectos
        echo "Nombre de usuario o contraseña incorrectos.";
    }
}
?>
