<?php
    require_once '../Conexion.php';
    require_once '../Clases/Profesor.php';
    require_once '../Clases/Materia.php';
    session_start();

    if(isset($_POST['id-materia'])){
        $id_materia = $_POST['id-materia'];
        $_SESSION['id_materia'] = $id_materia;
    }

    $rowprofesor = $_SESSION['rowprofesor'];
    $id_instituto = $_SESSION['id_instituto'];

    if(isset($_POST["fecha-asistencia"])){
        $fecha = $_POST["fecha-asistencia"];
    }else{
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date('Y-m-d');
    }

    
    $alumnoPresentes = Profesor::listadoPresentes($conexion,$id_instituto,$_SESSION['id_materia'],$fecha);
    $alumnoAusentes = Profesor::listadoAusentes($conexion,$id_instituto,$_SESSION['id_materia'],$fecha);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="../Resources/CSS/Profesor/listado.css">
    <link rel="stylesheet" href="../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../Resources/CSS/menu-fijo.css">
    <link rel="shortcut icon" href="../Resources/Images/icono.png" sizes="64x64">
    <script src="../Resources/JS/Profesor.js"></script>
    <script src="../Resources/JS/Menu.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<header class="encabezado">
    <a href="profesores-index.php"><img class="imagen-encabezado" src="../../Resources/Images/director-de-escuela.png"></a>
    <a href="profesores-index.php"><span class="bienvenido">Asist-o-Matic</span></a>

    <div class="container-button">
        <div><a href="../index.php"><img src="../Resources/Images/cerrar-sesion.png" class="img-session"><span class="span-sesion">CERRAR SESION</span></a></div>
    </div>
</header>

<div class="menu-container">
    <div id="mySidenav" class="sidenav">
        <div class="cont-menu">
            <a href="profesores-index.php"><img src="../../Resources/Images/menu.png" class="img-menu-admin"><span class="menu-span">Menu principal</span></a>
            <a href="funciones-profesor/tomar-asistencia.php"><img src="../../Resources/Images/tomar-asistencia.png" class="img-menu-admin"><span class="menu-span">Tomar asistencia</span></a>
            <a href="estado-alumno.php"><img src="../Resources/Images/graduado.png" class="img-menu-admin"><span class="alumno-span">Alumnos</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>
<body>

<div class="cantidad-asistencias" id="cantidad-asistencias">
    <img src="../Resources/Images/calendario.png" alt="" id="imagen-calendario">
    <span id="fecha-texto">Listado del día: <?php echo $fecha; ?></span>
    
    <div id="formulario-busqueda" class="formulario-busqueda">
        <div class="formulario-div">
            <form action="listado-alumnos.php" method="post">
                <input type="date" name="fecha-asistencia" class="date-formulario">
                <button type="submit" class="buscar-fecha"></button>
            </form>
        </div>
    </div>
</div>


    <div class="container-listado">
        <div class="top-listado"><span class="titulo">ALUMNOS PRESENTES</span></div>
        <div class="container-alumnos-listado">
            <form action="funciones-profesor/procesar-asistencia.php" method="post" id="formulario-salida">
                <?php
                    if($alumnoPresentes){
                        echo'<div class="alumno-top"><div class="top-id">ID</div><div class="top-nombre">NOMBRE COMPLETO</div><div class="top-dni">DNI</div><div class="top-fecha_nacimiento">FECHA DE NACIMIENTO</div><div class="top-asistencia">MARCAR SALIDA</div><div class="eliminar-asistencia-top">ELIMINAR ASISTENCIA</div></div>';
                        foreach ($alumnoPresentes as $alumnoPresente) {
                            echo '<div class="alumno">
                                    <div class="id">'.$alumnoPresente['id'].'</div>
                                    <div class="nombre">'.$alumnoPresente['nombre']." ".$alumnoPresente['apellido'].'</div>
                                    <div class="dni">'.$alumnoPresente['dni'].'</div>
                                    <div class="fecha_nacimiento">'.$alumnoPresente['fecha_nacimiento'].'</div>
                                    <div class="media-asistencia">
                                        <form action="funciones-profesor/procesar-asistencia.php" method="post">
                                            <input type="button" value="MARCAR SALIDA" class="boton-eliminar-asistencia" onclick="formularioMarcarSalida(this)">
                                            <input type="hidden" value="'.$alumnoPresente['id'].'" name="media-asistencia">
                                        </form>
                                    </div>
                                    <div class="eliminar-asistencia">
                                        <form action="funciones-profesor/procesar-asistencia.php" method="post">
                                            <input type="button" value="ELIMINAR ASISTENCIA" class="boton-eliminar-asistencia" onclick="formularioEliminarAsistencia(this)">
                                            <input type="hidden" value="'.$alumnoPresente['id'].'" name="id_eliminar">
                                        </form>
                                    </div>
                                </div>';
                        }
                    }else{
                        echo '<div class="contenedor-lista-asistencia"><div class="mensaje-asistencias-tomada">Hoy se encuentran todos asuentes😑</div></div>';
                    }
                ?>
            </form>
        </div>
    </div>

    <div class="container-listado">
        <div class="top-listado"></button><span class="titulo">ALUMNOS AUSENTES</span></div>
        <div class="container-alumnos-listado" id="container-alumnos">
            <form action="funciones-profesor/procesar-asistencia.php" method="post" id="formulario-tarde">
                <?php
                    if($alumnoAusentes){
                        echo'<div class="alumno-top"><div class="top-id">ID</div><div class="top-nombre-ausentes">NOMBRE COMPLETO</div><div class="top-dni-ausentes">DNI</div><div class="top-fecha_nacimiento">FECHA DE NACIMIENTO</div><div class="top-asistencia">MARCAR LLEGADA</div></div>';
                        foreach ($alumnoAusentes as $alumnoAusente) {
                            echo '<div class="alumno">
                                    <div class="id">'.$alumnoAusente['id'].'</div>
                                    <div class="nombre-ausente">'.$alumnoAusente['nombre']." ".$alumnoAusente['apellido'].'</div>
                                    <div class="dni-ausente">'.$alumnoAusente['dni'].'</div>
                                    <div class="fecha_nacimiento">'.$alumnoAusente['fecha_nacimiento'].'</div>
                                    <div class="media-asistencia">
                                        <form action="funciones-profesor/procesar-asistencia.php" method="post">
                                            <input type="button" value="MARCAR ENTRADA" class="boton-eliminar-asistencia" onclick="formularioMarcarEntrada(this)">
                                            <input type="hidden" value="'.$alumnoAusente['id'].'" name="asistencia-llegada">
                                        </form>
                                    </div>
                                </div>';
                        }
                    }else{
                        echo '<div class="contenedor-lista-asistencia"><div class="mensaje-asistencias-tomada">Hoy se encuentran todos presentes😦</div></div>';
                    }
                ?>
            </form>
        </div>
    </div>

</body>

<script src="../Resources/JS/boton.js"></script>
</html>