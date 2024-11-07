<?php
    require_once 'Conexion.php';
    require_once 'Clases/Usuario.php';
    require_once 'Clases/Profesor.php';
    session_start();
    


    if(isset($_POST["contrasena"])){
        $contrasena = $_POST["contrasena"];

        if(isset($_SESSION['rowprofesor'])){
            $row_profesor = $_SESSION['rowprofesor'];
            var_dump($row_profesor);
            $id = $row_profesor["id"];
            Profesor::cambiarContraseña($conexion,$id,$contrasena);
            header('location: index.php');
            exit();
        }
        
        if(isset($_SESSION['row'])){
            $row = $_SESSION['row'];
            $id = $row["id"];
            var_dump($row);
            Usuario::cambiarContraseña($conexion,$id,$contrasena);
            header('location: index.php');
            exit();
        }


    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/Resources/CSS/Profesor/cambio-contraseña.css">
    <script src="Resources/JS/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="contenedor">
        <div class="imagen-contenedor">
            <img src="/Resources/Images/icono.png" alt="">
        </div>
        <div class="contenedor-titulo">
            <span class="bienvenido">Asist-o-Matic</span>
        </div>
        <div class="texto">
            <span>• Por favor actualice su contraseña •</span>
        </div>
        <form action="Cambio-contraseña.php" method="post" id="formulario-contrasena" class="contenedor-imput">
            <div class="inputs-label">
                <label for="">Nueva contraseña</label>
                <input type="password" id="contrasena" name="contrasena">
            </div>
            <div class="inputs-label">
                <label for="">Repita contraseña</label>
                <input type="password" id="ncontrasena" name="ncontrasena">
            </div>

            <div class="contenedor-boton">
                <input type="button" value="ACTUALIZAR CONTRASEÑA" onclick="cambiarContraseña()">
            </div>
        </form>
    </div>
</body>
</html>