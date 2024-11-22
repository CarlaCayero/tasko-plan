<?php
include './db.php';

// Ejemplo de crear una tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $id_lista = $_POST['id_lista'];

    $stmt = $pdo->prepare("INSERT INTO tareas (titulo, descripcion, id_lista) VALUES (?, ?, ?)");
    $stmt->execute([$titulo, $descripcion, $id_lista]);

    echo json_encode(["status" => "success"]);
}

// Ejemplo de leer las tareas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query("SELECT * FROM tareas");
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tareas);
}
?>