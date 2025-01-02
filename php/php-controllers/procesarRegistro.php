<?php
include_once '../php-librarys/db.php';
include_once './usercontroller.php';

/* print_r($_POST);
exit; */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los datos existen
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        // Recibir los datos del formulario
        $nombre = trim($_POST['username']);
        $mail = trim($_POST['email']);
        $contrasenya = trim($_POST['password']);

        // Validar campos
        if (empty($nombre) || empty($mail) || empty($contrasenya)) {
            echo "Todos los campos son obligatorios.";
            exit;
        }

        // Intentar registrar al usuario
        $registroExitoso = registro($nombre, $contrasenya, $mail);

        if ($registroExitoso) {
            // Redirigir al index después de un registro exitoso
            header('Location: ../../index.html');
            exit; // Detener la ejecución del script después de la redirección
        } else {
            // Mostrar mensaje de error
            header('Location: ../../html/registro.php');
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>