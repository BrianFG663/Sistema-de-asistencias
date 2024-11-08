<?php
    require_once '../../Conexion.php';
    require_once '../../Clases/Profesor.php';

    session_start();
    $rowprofesor = $_SESSION['rowprofesor'];
    $instituto_id = $_SESSION['id_instituto'];
    $materia_id = $_SESSION['id_materia'];

    $profesor = new Profesor($rowprofesor['nombre'],$rowprofesor['apellido'],$rowprofesor['dni'],$rowprofesor['legajo']);
    $alumnos = $profesor->mostrarAlumnos($conexion,$materia_id,$instituto_id);

?>

<?php

    if(isset($_POST['id_eliminar'])){
        $id_alumno = $_POST['id_eliminar'];
        Profesor::eliminarAlumno($id_alumno,$conexion);

        header('location: eliminar-alumnos.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar profesor</title>
    <link rel="shortcut icon" href="../../Resources/Images/icono.png" sizes="64x64">
    <link rel="stylesheet" href="../../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../../Resources/CSS/Profesor/alumno-index.css">
    <link rel="stylesheet" href="../../Resources/CSS/menu-fijo.css">

    <script src="../../Resources/JS/Profesor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../Resources/JS/Menu.js"></script>
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
            <a href="crear-alumnos.php"><img src="../../Resources/Images/agregar alumno.png" class="img-menu-admin"><span class="agregar-alumno-span">Agregar alumno</span></a>
            <a href="../estado-alumno.php"><img src="../../Resources/Images/graduado.png" class="img-menu-admin"><span class="alumno-span">Alumnos</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>

<body>
<div class="eliminar-alumno">
        <div class="top"><button class="button-back" onclick="redireccion(2)"></button><span class="titulo">INSTITUTOS DISPONIBLES</span></div>
        <div class="container-alumnos">
                <?php
                    if(!$alumnos){
                        echo "<div class='mensaje-alumno'>No hay alumnos en esta materia 😑</div>";
                    }else{
                        echo'<div class="alumno-top"><div class="top-id">ID</div><div class="top-nombre-eliminar">NOMBRE COMPLETO</div><div class="top-dni-eliminar">DNI</div><div class="top-fecha_nacimiento">FECHA DE NACIMIENTO</div><div class="eliminar-asistencia-top">ELIMINAR ALUMNO</div></div>';
                        foreach ($alumnos as $alumno) {
                            echo '<div class="alumno">
                                    <div class="id">'.$alumno['id'].'</div>
                                    <div class="nombre-eliminar">'.$alumno['nombre']." ".$alumno['apellido'].'</div>
                                    <div class="dni-eliminar">'.$alumno['dni'].'</div>
                                    <div class="fecha_nacimiento">'.$alumno['fecha_nacimiento'].'</div>
                                    <div class="eliminar-asistencia">
                                        <form action="eliminar-alumnos.php" method="post">
                                            <input type="button" value="ELIMINAR ALUMNO" class="boton-eliminar-asistencia" onclick="formularioEliminarAlumno(this)">
                                            <input type="hidden" value="'.$alumno['id'].'" name="id_eliminar">
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

<?php

    require_once '../../Conexion.php';
    require_once '../../Clases/Alumno.php';

    if(isset($_POST['nombre-alumno'])){
        $nombre = $_POST['nombre-alumno'];
        $apellido = $_POST['apellido-alumno'];
        $dni = $_POST['dni-alumno'];
        $fecha_nacimiento =$_POST['fecha-alumno'];

        $alumno = new Alumno($nombre,$apellido,$dni,$fecha_nacimiento);
        $alumno->inscribirAlumno($conexion,$instituto_id,$materia_id);
    }

?>