<?php
function openDb()
{

   // $host = "sql311.byethost33.com";
   // $user = "b33_37391784";
   // $password = "1Q2w3e4r5t.";
   // $dbname = "b33_37391784_taskoplan";

    $host = "mysql_xampp";
    $user = "root";
    $password = "";
    $dbname = "taskoplan";

    try{
        $conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->exec("set names utf8");
    
        return $conexion;
    }catch (PDOException $e){
        die("Error al conectar con la base de datos: " . $e->getMessage());
    }
    
}

function closeDb()
{
    return null;
}

function errorMessage($e)
{
    if(!empty($e->errorInfo[1]))
    {
        switch ($e->errorInfo[1]) {
            case 1062:
                $mensaje = 'Registro duplicado';
                break;
            case 1451: 
                $mensaje = 'Registro con elementos relacionados';
                break;
            default:
                $mensaje = $e->errorInfo[1] . ' - ' . $e->errorInfo[2];
                break;
        }
    } 
    else
    {
        switch ($e->getCode()) {
            case 1044:
                $mensaje = 'Usuario y/o password incorrecto';
                break;
            case 1049: 
                $mensaje = 'Base de datos desconocida';
                break;
            case 2002: 
                $mensaje = 'No se encuentra el servidor';
                break;
            default:
                $mensaje = $e->getCode() . ' - ' . $e->getMessage();
                break;
        }
    }
    return $mensaje;
}

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
        $sentenciaText = "INSERT INTO usuario (nombre, contrasenya,email, id_rol) VALUES (:nombre, :contrasenya, :mail, 3)";
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

function modificarUsuario($id_usuario, $nombre, $contrasenya, $id_rol)
{

    try {
        $conexion = openDb();
        $sentenciaText = "UPDATE usuario SET nombre = :nombre, contrasenya = :contrasenya, id_rol = :id_rol WHERE id_usuario = :id_usuario";

        $stmt = $conexion->prepare($sentenciaText);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':contrasenya', $contrasenya);
        $stmt->bindParam(':id_rol', $id_rol);
        $stmt->bindParam(':id_usuario', $id_usuario);

        $stmt->execute();

        closeDb();
    } catch (PDOException $e) {
        return errorsMessage($e);
    }
}

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

?>