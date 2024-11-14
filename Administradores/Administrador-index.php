<?php
session_start();
$row = $_SESSION['row'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../Resources/CSS/Administrador/Administrador-index.css">
    <link rel="stylesheet" href="../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../Resources/CSS/menu-fijo.css">
    <link rel="shortcut icon" href="../Resources/Images/icono.png" sizes="64x64">
    <script src="../Resources/JS/administrador.js"></script>
    <script src="../Resources/JS/Menu.js"></script>
</head>

<header class="encabezado">
    <a href="Administrador-index.php"><img class="imagen-encabezado" src="../../Resources/Images/director-de-escuela.png"></a>
    <a href="Administrador-index.php"><span class="bienvenido">Asist-o-Matic</span></a>

    <div class="container-button">
        <div><a href="../index.php"><img src="../Resources/Images/cerrar-sesion.png" class="img-session"><span class="span-sesion">CERRAR SESION</span></a></div>
    </div>
</header>

<div class="menu-container">
    <div id="mySidenav" class="sidenav">
        <div class="cont-menu">
            <a href="/Administradores/Tablas-DB/Materias-db.php"><img src="../Resources/Images/libros.png" class="img-menu-admin"><span class="span-materias">Materias</span></a>
            <a href="/Administradores/Tablas-DB/Institutos-db.php"><img src="../Resources/Images/instituto.png" class="img-menu-admin"><span class="span-institutos">Institutos</span></a>
            <a href="/Administradores/Tablas-DB/Profesores-db.php"><img src="../Resources/Images/profesor.png" class="img-menu-admin"><span class="span-profesor">Profesores</span></a>
            <a href="/Administradores/Tablas-DB/Administradores-db.php"><img src="../Resources/Images/gerente.png" class="img-menu-admin"><span class="admin-span">Administradores</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../Resources/Images/gerente.png" alt="">
            <span class="span-div"><?php echo  $row['nombre']." ".$row['apellido'] ?></span>
        </div>
    </div>
</div>

<body>
    <div class="contenedor-body">
        <div class="encabezado-contenedor">
            <span class="titulo-encabezado">Bienvenido <?php echo $row['nombre']?></span>
        </div>

        <button onclick="redireccion(this.value)" class="boton-body" id="boton-redireccion" value="1">Agregar materia</button>
        <button onclick="redireccion(this.value)" class="boton-body" id="boton-redireccion" value="3">Agregar instituto</button>
        <button onclick="redireccion(this.value)" class="boton-body" id="boton-redireccion" value="2">Agregar profesor</button>
        <button onclick="redireccion(this.value)" class="boton-body" id="boton-redireccion" value="4">Agregar administrador</button>
    </div>
</body>


</html>