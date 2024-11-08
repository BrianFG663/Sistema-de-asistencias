<?php
require_once '../../Conexion.php';
require_once '../../Clases/Materia.php';
require_once '../../Clases/Instituto.php';
session_start();
$rowprofesor = $_SESSION['rowprofesor'];
$instituto_id = $_SESSION['id_instituto'];

$instituto = Instituto::buscarInstituto($conexion,$instituto_id); 
$materias_libres= Materia::buscarMateria($conexion,$instituto_id);
?>

<?php

    if(isset($_POST['id_materia'])){
        $materia_id = $_POST['id_materia'];
        $profesor_id = $rowprofesor['id'];
        Materia::asignarProfesor($conexion,$materia_id,$profesor_id,$instituto_id);

        header('location: inscribirse-materia.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="../../Resources/CSS/Profesor/alumno-index.css">
    <link rel="stylesheet" href="../../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../../Resources/CSS/menu-fijo.css">
    <link rel="shortcut icon" href="../../Resources/Images/icono.png" sizes="64x64">
    <script src="../../Resources/JS/Profesor.js"></script>
    <script src="../../Resources/JS/Menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<header class="encabezado">
    <a href="../profesores-index.php"><img class="imagen-encabezado" src="../../Resources/Images/director-de-escuela.png"></a>
    <a href="../profesores-index.php"><span class="bienvenido">Asist-o-Matic</span></a>

    <div class="container-button">
        <div><a href="../../index.php"><img src="../../Resources/Images/cerrar-sesion.png" class="img-session"><span class="span-sesion">CERRAR SESION</span></a></div>
    </div>
</header>

<div class="menu-container">
    <div id="mySidenav" class="sidenav">
        <div class="cont-menu">
            <a href="../profesores-index.php"><img src="../../Resources/Images/menu.png" class="img-menu-admin"><span class="menu-span">Menu principal</span></a>
            <a href="quitar-materia.php"><img src="../../Resources/Images/quitar-materia.png" class="img-menu-admin"><span class="span-institutos">Materias</span></a>
            <a href="cambiar-parametros.php"><img src="../../Resources/Images/parametros.png" class="img-menu-admin"><span class="span-parametros">Parametros</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>

<body>
    <div class="container-materia">
        <div class="top"><button class="button-back" onclick="redireccion(2)"></button><span class="titulo">MATERIAS DISPONIBLES EN <?php echo $instituto['nombre'] ?></span></div>
        <div class="container-alumnos">
                <?php
                    if(!$materias_libres){
                        echo "<div class='mensaje-materias'>NO HAY MATERIAS DISPONIBLES EN ESTE INSTITUTO</div>";
                    }else{
                        echo '<div class="contenedor-materia-top"><div class="id-materia-top">ID</div><div class="nombre_materia_top">NOMBRE</div><div class="descripcion-top">DESCRIPCION</div><div class="fecha_descripcion-top">FECHA DE CREACION</div><div class="codigo_materia-top">CODIGO DE MATERIA</div><div class="div-inscribirse-materia-top">¿DESEA INSCRIBIRSE?</div></div>';
                        foreach ($materias_libres as $materias) {
                            echo '<div class="contenedor-materia">
                                    <div class="id-materia">'.$materias['id'].'</div>
                                    <div class="nombre_materia">'.$materias['nombre'].'</div>
                                    <div class="descripcion">'.$materias['descripcion'].'</div>
                                    <div class="fecha_descripcion">'.$materias['fecha_creacion'].'</div>
                                    <div class="codigo_materia">'.$materias['codigo_materia'].'</div>
                                        <div class="div-inscribirse-materia">
                                            <form action="'.$_SERVER['PHP_SELF'].'" method="post" id="formulario-incribir-materia">
                                                <input class="boton-inscribirse-materia" type="button" value="INSCRIBIRSE A LA MATERIA" onclick="formularioInscribirMateria(this)">
                                                <input type="hidden" name="id_materia" value="'.$materias['id'].'">
                                            </form>
                                        </div>
                                </div>';
                        }
                    }

                ?>
        </div>
    </div>
</body>
</html>


