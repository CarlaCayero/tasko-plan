<?php
include_once '../php-librarys/db.php'

// Registra a nuevos usuarios
function registro($nombre, $contrasenya, $mail)
{
    try {
        $conexion = openDb();

        // Comprobar si el nombre de usuario o el correo ya están registrados
        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE nombre = :nombre OR mail = :mail");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false; // Usuario o correo ya registrado
        }

        // Encriptar la contraseña
        $hashedPassword = password_hash($contrasenya, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $sentenciaText = "INSERT INTO usuario (nombre, contrasenya, mail) VALUES (:nombre, :contrasenya, :mail)";
        $stmt = $conexion->prepare($sentenciaText);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':contrasenya', $hashedPassword);
        $stmt->bindParam(':mail', $mail);

        if (!$stmt->execute()) {
            print_r($stmt->errorInfo()); // Mostrar errores en caso de fallo
        }

        $conexion = closeDb();

        return true;
    } catch (PDOException $e) {
        return errorMessage($e); // Manejar errores de la base de datos
    }
}

// Modifica usuarios
function modificarUsuario($id_usuario, $nombre, $contrasenya, $id_rol)
{

    try {
        $conexion = openDb();
        $sentenciaText = "UPDATE usuario SET nombre = :nombre, contrasenya = :contrasenya WHERE id_usuario = :id_usuario";

        $stmt = $conexion->prepare($sentenciaText);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':contrasenya', $contrasenya);
        $stmt->bindParam(':id_usuario', $id_usuario);

        $stmt->execute();

        closeDb();
    } catch (PDOException $e) {
        return errorsMessage($e);
    }
}

// Elimina usuarios
function borrarUsuario($id_usuario)
{
    try {
        $conexion = openDb();
        $sentenciaText = "DELETE FROM usuario WHERE id_usuario = :id_usuario";

        $stmt = $conexion->prepare($sentenciaText);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        $conexion = closeDb();
    } catch (PDOException $e) {
        return errorsMessage($e);
    }
}

// Permite buscar un usuario por su ID o nombre.
function getUsuario($id_usuario) 
{
    try {
        $conexion = openDb();
        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $conexion = closeDb();

        return $usuario;
    } catch (PDOException $e) {
        return errorMessage($e);
    }
}

// Devuelve una lista de todos los usuarios registrados.
function getUsuarios() 
{
    try {
        $conexion = openDb();
        $stmt = $conexion->query("SELECT * FROM usuario");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $conexion = closeDb();

        return $usuarios;
    } catch (PDOException $e) {
        return errorMessage($e);
    }
}

// Busca el nombre del rol asociado a un id_rol.
function getRol($id_rol) 
{
    try {
        $conexion = openDb();
        $stmt = $conexion->prepare("SELECT * FROM rol WHERE id_rol = :id_rol");
        $stmt->bindParam(':id_rol', $id_rol);
        $stmt->execute();

        $rol = $stmt->fetch(PDO::FETCH_ASSOC);
        $conexion = closeDb();

        return $rol;
    } catch (PDOException $e) {
        return errorMessage($e);
    }
}

// Para validar usuarios.
function verificarUsuario($nombre, $contrasenya) 
{
    try {
        $conexion = openDb();
        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE nombre = :nombre");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Validar contraseña
        if ($usuario && password_verify($contrasenya, $usuario['contrasenya'])) {
            return $usuario; // Usuario válido
        } else {
            return false; // Credenciales incorrectas
        }
    } catch (PDOException $e) {
        return errorMessage($e);
    }
}

?>