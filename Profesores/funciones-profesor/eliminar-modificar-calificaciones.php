<?php
    session_start();

    require_once '../../Conexion.php';
    require_once '../../Clases/Materia.php';
    require_once '../../Clases/Alumno.php';
    require_once '../../Clases/Profesor.php';

    if(isset($_POST["id-alumno"])){
        $id_alumno = intval($_POST["id-alumno"]);
        $_SESSION["id-alumno"] = $_POST["id-alumno"];
    }

    
    $id_materia = intval($_SESSION['id_materia']);
    $rowprofesor = $_SESSION['rowprofesor'];

    $alumno = Alumno::getAlumno($conexion,$_SESSION["id-alumno"]);
    $materia = Materia::getMateria($conexion,$id_materia);
    $notas = Alumno::notasAlumno($conexion,$_SESSION["id-alumno"]);


    if(isset($_POST['id_editar'])){
        $id = $_POST['id_editar'];
        $nota = $_POST['nota-nueva'];
        Profesor::editarNota($conexion,$id,$nota);

        header('location: eliminar-modificar-calificaciones.php');
        exit();
    }

    if(isset($_POST['id_eliminar'])){
        $id = $_POST['id_eliminar'];
        Profesor::eliminarNota($conexion,$id);

        header('location: eliminar-modificar-calificaciones.php');
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
            <a href="tomar-asistencia.php"><img src="../../Resources/Images/tomar-asistencia.png" class="img-menu-admin"><span class="menu-span">Tomar asistencia</span></a>
            <a href="../estado-alumno.php"><img src="../../Resources/Images/graduado.png" class="img-menu-admin"><span class="alumno-span">Alumnos</span></a>
            <a href="crear-alumnos.php"><img src="../../Resources/Images/agregar alumno.png" class="img-menu-admin"><span class="agregar-alumno-span">Agregar alumno</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>
<body>
    <div class="container-materia-notas">
        <div class="top"><span class="titulo">EDITAR-ELIMINAR NOTAS</span></div>
        <div class="container-alumnos">
                <?php
                    if(!$notas){
                        echo "<div class='mensaje-materias'>ESTE ALUMNO NO TIENE AUN NO TIENE CALIFICACIONES</div>";
                    }else{
                        echo '<div class="contenedor-materia-top"><div class="nombre_alumno_top">ALUMNO</div><div class="materia-top">MATERIA</div><div class="fecha-top">FECHA DE ENTREGA</div><div class="nota-top">NOTA</div><div class="editarnota-top">EDITAR NOTA</div><div class="eliminarnota-top">ELIMINAR NOTA</div></div>';
                        foreach ($notas as $nota) {
                            echo '<div class="contenedor-materia">
                                    <div class="nombre-alumno">'.$alumno['nombre'].' '.$alumno['apellido'].'</div>
                                    <div class="materia-nombre">'.$materia['nombre'].'</div>
                                    <div class="fecha-nota">'.$nota['fecha_nota'].'</div>
                                    <div class="nota">'.$nota['nota'].'</div>
                                    <div class="div-editar-nota">
                                        <form action="eliminar-modificar-calificaciones.php" method="post" id="formulario-modificar-nota">
                                            <input type="number" name="nota-nueva" id="nota-nueva" class="nota-nueva" placeholder="INGRESAR NOTA...">
                                            <input type="hidden" name="id_editar" value="'.$nota['id'].'">
                                            <input class="boton-editar-nota" type="button" value="MODIFICAR" onclick="formularioEditarNota(this)">
                                        </form>
                                    </div>
                                    <div class="div-eliminar-nota">
                                        <form action="'.$_SERVER['PHP_SELF'].'" method="post" id="formulario-eliminar-materia">
                                            <input class="boton-eliminar-nota" type="button" value="ELIMINAR" onclick="formularioeliminarNota(this)">
                                            <input type="hidden" name="id_eliminar" value="'.$nota['id'].'">
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
