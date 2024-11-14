<?php
require_once '../../Conexion.php';
require_once '../../Clases/Profesor.php';
require_once '../../Clases/Instituto.php';
session_start();
$rowprofesor = $_SESSION['rowprofesor'];
$profesor_id = $rowprofesor['id'];

$institutos = Instituto::institutosLibres($conexion,$profesor_id); 
?>


<?php

    if (isset($_POST['id_instituto'])){
        $instituto_id = $_POST['id_instituto'];
        Profesor::asignarInstituto($conexion,$profesor_id,$instituto_id);

        header('location: inscribirse-instituto.php');
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
            <a href="quitar-instituto.php"><img src="../../Resources/Images/quitar-instituto.png" class="img-menu-admin"><span class="span-institutos">Institutos</span></a>
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
        <div class="top"><button class="button-back" onclick="redireccion(2)"></button><span class="titulo">INSTITUTOS DISPONIBLES</span></div>
        <div class="container-alumnos">
                <?php
                    if(!$institutos){
                        echo "<div class='mensaje-materias'>NO HAY INSTITUTOS DISPONIBLES</div>";
                    }else{
                        echo '<div class="contenedor-materia-top"><div class="id-materia-top">ID</div><div class="nombre_materia_top">NOMBRE</div><div class="descripcion-top">DIRECCION</div><div class="fecha_descripcion-top">C.U.E</div><div class="codigo_materia-top">GESTION DEL INSTITUTO</div><div class="div-inscribirse-materia-top">¿DESEA INSCRIBIRSE?</div></div>';
                        foreach ($institutos as $instituto) {
                            echo '<div class="contenedor-materia">
                                    <div class="id-materia">'.$instituto['id'].'</div>
                                    <div class="nombre_materia">'.$instituto['nombre'].'</div>
                                    <div class="descripcion">'.$instituto['direccion'].'</div>
                                    <div class="fecha_descripcion">'.$instituto['cue'].'</div>
                                    <div class="codigo_materia">'.$instituto['gestion'].'</div>
                                        <div class="div-inscribirse-materia">
                                            <form action="'.$_SERVER['PHP_SELF'].'" method="post"  id="inscribir-profesor">
                                                <input class="boton-inscribirse-materia" type="button" value="INSCRIBIRSE AL INSTITUTO" onclick="formularioInscribirInstituto(this)">
                                                <input type="hidden" name="id_instituto" value="'.$instituto['id'].'">
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

