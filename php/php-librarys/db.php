<?php
function openDb()
{

   // $host = "sql311.byethost33.com";
   // $user = "b33_37391784";
   // $password = "1Q2w3e4r5t.";
   // $dbname = "b33_37391784_taskoplan";

    $host = "localhost";
    $user = "root";
    $password = "mysql";
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

?>