<?php
    require_once '../../Conexion.php';
    require_once '../../Clases/Profesor.php';
    require_once '../../Clases/Materia.php';
    session_start();

    if(isset($_POST['id-materia'])){
        $id_materia = $_POST['id-materia'];
        $_SESSION['id_materia'] = $id_materia;
    }

    $rowprofesor = $_SESSION['rowprofesor'];
    $id_instituto = $_SESSION['id_instituto'];
    $profesor = new Profesor($rowprofesor['nombre'],$rowprofesor['apellido'],$rowprofesor['dni'],$rowprofesor['legajo']);
    $alumnos = $profesor->mostrarAlumnos($conexion,$_SESSION['id_materia'],$id_instituto);
    $asistencia_dia = Materia::asistenciasDia($conexion,$_SESSION['id_materia']);

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
            <a href="../listado-alumnos.php"><img src="../../Resources/Images/listado.png" class="img-menu-admin"><span class="span-listado">Listado diario</span></a>
            <a href="calificaciones.php"><img src="../../Resources/Images/calificaciones.png" class="img-menu-admin"><span class="calificaciones-span">Calificaciones</span></a>
            <a href="../estado-alumno.php"><img src="../../Resources/Images/graduado.png" class="img-menu-admin"><span class="alumno-span">Alumnos</span></a>
            <a href="crear-alumnos.php"><img src="../../Resources/Images/agregar alumno.png" class="img-menu-admin"><span class="agregar-alumno-span">Agregar alumno</span></a>         </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>
<body>
    <div class="container">
        <div class="top"><button class="button-back" onclick="redireccion(2)"></button><span class="titulo">LISTADO DE ALUMNOS</span></div>
        <div class="container-alumnos">
        <?php if($asistencia_dia){  //abre el if del booleano nque comprueba si se tomo la asistencia de esta materia el dia actual?> 
            <form action="procesar-asistencia.php" method="post" id="formulario-asistencias">
                <?php
                    if (!$alumnos) {
                        echo "<div class='mensaje-alumno'>No hay alumnos en esta materia 😑</div>";
                    } else {
                        echo'<div class="alumno-top"><div class="top-id">ID</div><div class="top-nombre-ausentes">NOMBRE COMPLETO</div><div class="top-dni-ausentes">DNI</div><div class="top-fecha_nacimiento">FECHA DE NACIMIENTO</div><div class="top-asistencia">ASISTENCIA</div></div>';
                        foreach ($alumnos as $alumno) {
                            echo '<div class="alumno">
                                    <div class="id">'.$alumno['id'].'</div>
                                    <div class="nombre-ausente">'.$alumno['nombre']." ".$alumno['apellido'].'</div>
                                    <div class="dni-ausente">'.$alumno['dni'].'</div>
                                    <div class="fecha_nacimiento">'.$alumno['fecha_nacimiento'].'</div>
                                    <input type="checkbox" class="asistencia" name="asistencia[]" value="'.$alumno['id'].'">
                                </div>';
                        }
                    }
                ?>
            </form>
        </div>
        <?php
        
        if($alumnos){
           echo '<div class="boton"><input class="boton-tomar-asistencia" type="button" value="SUBIR ASISTENCIA" onclick="formularioAsistencias()"></div>';
        }
        
        }else{ //cierra el if del booleano nque comprueba si se tomo la asistencia de esta materia el dia actual
            echo '<div class="contenedor-lista"><div class="mensaje-asistencias-tomada">Ya se tomo asistencia este dia😊</div></div>';
        }
        ?>
    </div>
</body>
</html>