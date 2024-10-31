<?php
require_once '../../Conexion.php';
require_once '../../Clases/Profesor.php';
require_once '../../Clases/Materia.php';
session_start();
$rowprofesor = $_SESSION['rowprofesor'];
$profesor_id = $rowprofesor['id'];
$instituto_id = $_SESSION['id_instituto'];

$materias = Profesor::mostrarMaterias($conexion,$profesor_id,$instituto_id); 
?>


<?php
    if (isset($_POST['id_materia'])){
        $materia_id = $_POST['id_materia'];
        Materia::quitarProfesor($conexion,$materia_id);
        
        header('location: quitar-materia.php');
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
    <img class="imagen-encabezado" src="../../Resources/Images/director-de-escuela.png">
    <span class="bienvenido">Asist-o-Matic</span>

    <div class="container-button">
        <div><a href="../../index.php"><img src="../../Resources/Images/cerrar-sesion.png" class="img-session"><span class="span-sesion">CERRAR SESION</span></a></div>
    </div>
</header>

<div class="menu-container">
    <div id="mySidenav" class="sidenav">
        <div class="cont-menu">
            <a href="../profesores-index.php"><img src="../../Resources/Images/menu.png" class="img-menu-admin"><span class="menu-span">Menu principal</span></a>
            <a href="inscribirse-materia.php"><img src="../../Resources/Images/agregar materia.png" class="img-menu-admin"><span class="span-institutos">Materias</span></a>
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
        <div class="top"><button class="button-back" onclick="redireccion(2)"></button><span class="titulo"></span></div>
        <div class="container-alumnos">
                <?php
                    if(!$materias){
                        echo "<div class='mensaje-materias'>NO HAY MATERIAS DISPONIBLES EN ESTE INSTITUTO</div>";
                    }else{
                        echo '<div class="contenedor-materia-top"><div class="id-materia-top">ID</div><div class="nombre_materia_top">NOMBRE</div><div class="descripcion-top">DESCRIPCION</div><div class="fecha_descripcion-top">FECHA DE CREACION</div><div class="codigo_materia-top">CODIGO DE MATERIA</div><div class="div-inscribirse-materia-top">¿DESEA INSCRIBIRSE?</div></div>';
                        foreach ($materias as $materia) {
                            echo '<div class="contenedor-materia">
                                    <div class="id-materia">'.$materia['id'].'</div>
                                    <div class="nombre_materia">'.$materia['nombre'].'</div>
                                    <div class="descripcion">'.$materia['descripcion'].'</div>
                                    <div class="fecha_descripcion">'.$materia['fecha_creacion'].'</div>
                                    <div class="codigo_materia">'.$materia['codigo_materia'].'</div>
                                        <div class="div-inscribirse-materia">
                                            <form action="'.$_SERVER['PHP_SELF'].'" method="post" id="formulario-eliminar-materia">
                                                <input class="boton-eliminar-instituto" type="button" value="ELIMINAR A LA MATERIA" onclick="formularioInscribirMateria(this)">
                                                <input type="hidden" name="id_materia" value="'.$materia['id'].'">
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

