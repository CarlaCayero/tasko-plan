<?php 
session_start();
?>

<?php
$host = "mysql_xampp";
$user = "root";
$password = "";
$dbname = "taskoplan";

function openBd(){
    try{
        $conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->exec("set names utf8");
    
        return $conexion;
    }catch (PDOException $e){
        die("Error al conectar con la base de datos: " . $e->getMessage());
    }
    
}

function closeBd(){
    return null;
}

?>