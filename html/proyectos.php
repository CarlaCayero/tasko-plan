<?php
include_once '../php/php-librarys/db.php';
include_once '../php/php-controllers/userController.php';
include_once '../php/php-controllers/projectController.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: iniciarSesion.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$proyectos = obtenerProyectosPorUsuario($id_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
    <title>TaskoPlan: Proyectos</title>
</head>
<body>
    <header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <h1>Mis Proyectos</h1>
                <div class="d-flex align-items-center">
                    <a href="../index.html">
                        <img src="../media/index/cerrarSesion.png" alt="Cerrar Sesión" class="img-logo">
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container vh-100 d-flex align-items-center position-relative">
        <section>
            <button id="btn-add-p" class="btn btn-standard">Añadir Proyecto</button>
            <div class="row" id="p-container">
                <?php if (!empty($proyectos)): ?>
                    <?php foreach ($proyectos as $proyecto): ?>
                        <div class="col-md-4 mb-4" data-id-proyecto="<?= $proyecto['id_proyecto'] ?>">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($proyecto['nombre']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($proyecto['descripcion']) ?></p>
                                    <a href="../html/tareas.php?id_proyecto=<?= $proyecto['id_proyecto'] ?>" class="btn btn-standard" id="g-tarea">Gestionar Tareas</a>
                                    <button class="btn btn-dark btn-del-p">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes proyectos creados.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Modal para crear un nuevo proyecto -->
    <div class="modal fade" id="crear-p-modal" tabindex="-1" aria-labelledby="crear-p-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crear-p-modal-label">Crear Proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Proyecto</label>
                        <input type="text" class="form-control" id="p-nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="p-descripcion" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-guardar-p" class="btn btn-standard">Guardar Proyecto</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlazar el archivo JavaScript externo -->
    <script src="../js/proyectos.js"></script>
</body>
</html>
