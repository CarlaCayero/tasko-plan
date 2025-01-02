<?php
include_once '../php/php-librarys/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
    <title>TaskoPlan: Registro</title>
</head>
<body>
    <header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <a href="../index.html">
                    <img src="../media/index/atras.png" alt="Volver" class="img-logo">
                </a>
            </div>
        </nav>
    </header>
    <main>
        <div class="container vh-100 d-flex align-items-center position-relative">
            <div class="row w-100">
                <div class="col-md-6 d-flex justify-content-start align-items-center">
                    <img src="../media/index/logotipo.png" alt="Imagen" class="img-logo-xl img-fluid">
                </div>

                <div class="col-md-6">
                    <div class="container text-center mt-3">
                        <h1 class="fs-3">Regístrate para empezar a planificar con Tasko Plan</h1>
                        <hr>
                    </div>
                    <!-- El formulario que envía datos a registro.php -->
                    <form method="POST" action="../php/php-controllers/procesarRegistro.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Introduce tu nombre de usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
                        </div>
                        <!-- Asegúrate de que el botón tiene el estilo adecuado -->
                        <button type="submit" class="btn btn-standard" id="btn-aceptar">Aceptar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
