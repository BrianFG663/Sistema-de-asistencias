<?php
    include_once 'Setup.php';
    session_unset();

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="Resources/css/index.css">
    <link rel="shortcut icon" href="Resources/Images/icono.png" sizes="64x64">
</head>
<body>
    <div class="container">
        <h1>Asist-o-Matic</h1>
    </div>

    <div class="form">
        <div class="thumbnail"><img src="/Resources/Images/director-de-escuela.png"/></div>
        <form class="login-form" id="formulario-login" method="post" action="main-login.php">
            <input type="text" placeholder="Ingrese E-Mail." name="login-name" id="login-nombre"/>
            <input type="password" placeholder="Ingrese contraseña" name="login-pass" id="login-pass"/>
            <input type="button" value="Iniciar sesion" onclick="verificarFormulario()" id="login-button">
        </form>
    </div>
    
</body>

<script src="Resources/JS/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>