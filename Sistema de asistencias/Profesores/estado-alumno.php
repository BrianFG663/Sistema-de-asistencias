<?php
    require_once '../Conexion.php';
    require_once '../Clases/Profesor.php';
    require_once '../Clases/Instituto.php';
    require_once '../Clases/Alumno.php';
    require_once '../Clases/Materia.php';
    session_start();

    if(isset($_POST['id-materia'])){
        $id_materia = $_POST['id-materia'];
        $_SESSION['id_materia'] = $id_materia;
    }
    
    $id_materia = $_SESSION['id_materia'];
    $rowprofesor = $_SESSION['rowprofesor'];
    $id_instituto = $_SESSION['id_instituto'];

    $profesor = new Profesor($rowprofesor['nombre'],$rowprofesor['apellido'],$rowprofesor['dni'],$rowprofesor['legajo']);
    $alumnos = $profesor->mostrarAlumnos($conexion,$_SESSION['id_materia'],$id_instituto);
    $ram = Instituto::getRam($conexion,$id_instituto);
    $asistencias_materia = Materia::asistenciasMateria($conexion,$id_materia);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="../Resources/CSS/Profesor/estado-alumno.css">
    <link rel="stylesheet" href="../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../Resources/CSS/menu-fijo.css">
    <link rel="shortcut icon" href="../Resources/Images/icono.png" sizes="64x64">
    <script src="../Resources/JS/Profesor.js"></script>
    <script src="../Resources/JS/Menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<header class="encabezado">
    <img class="imagen-encabezado" src="../../Resources/Images/director-de-escuela.png">
    <span class="bienvenido">Asist-o-Matic</span>

    <div class="container-button">
        <div><a href="../index.php"><img src="../Resources/Images/cerrar-sesion.png" class="img-session"><span class="span-sesion">CERRAR SESION</span></a></div>
    </div>
</header>

<div class="menu-container">
    <div id="mySidenav" class="sidenav">
        <div class="cont-menu">
            <a href="profesores-index.php"><img src="../../Resources/Images/menu.png" class="img-menu-admin"><span class="menu-span">Menu principal</span></a>
            <a href="funciones-profesor/tomar-asistencia.php"><img src="../../Resources/Images/tomar-asistencia.png" class="img-menu-admin"><span class="menu-span">Tomar asistencia</span></a>
            <a href="funciones-profesor/calificaciones.php"><img src="../Resources/Images/calificaciones.png" class="img-menu-admin"><span class="calificaciones-span">Calificaciones</span></a>
            <a href="funciones-profesor/crear-alumnos.php"><img src="../Resources/Images/agregar alumno.png" class="img-menu-admin"><span class="agregar-alumno-span">Agregar alumno</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div> 

<body>

    <div class="container">
        <div class="top"></button><span class="titulo">ESTADO DE LOS ALUMNOS</span></div>
        <div class="container-alumnos">
        <?php
            echo'<div class="alumno-top"><div class="top-id">ID</div><div class="top-nombre">NOMBRE COMPLETO</div><div class="top-dni">DNI</div><div class="notas-top">NOTAS PARCIALES/TRABAJOS</div><div class="asistencias-top">ASISTENCIA</div><div class="estado-top">ESTADO</div></div>';       
                foreach ($alumnos as $alumno) {

                    $notas = Alumno::notasAlumno($conexion,$alumno['id']); //funcion trae las notas del alumno
                    $asistencias_alumno = Alumno::asistenciasAlumno($conexion,$id_materia,$alumno['id'],$asistencias_materia,$ram);
                    $asistencias_alumno = floatval($asistencias_alumno);
                    $asistencias_alumno = round($asistencias_alumno, 0);
                    $estado = Alumno::estadoAlumno($conexion,$alumno['id'],$ram,$asistencias_alumno);


                    echo '<div class="alumno">
                            <div class="id">' . $alumno['id'] . '</div>
                            <div class="nombre">' . $alumno['nombre'] . " " . $alumno['apellido'] . '</div>
                            <div class="dni">' . $alumno['dni'] . '</div>
                            <div class="notas">
                            <form action="funciones-profesor/eliminar-modificar-calificaciones.php" method="post" id="formulario-eliminar-nota"><input type="hidden" name="id-alumno" value="' . $alumno['id'] . '"><input type="button" value="ELIMINAR-MODIFICAR NOTAS" class="eliminar-nota" id="eliminar-nota" onclick="editarEliminarNota(this)"></form>';
                    if (!empty($notas)) {
                        foreach ($notas as $nota) { 
                            echo '<div class="nota-individual">' . $nota['nota'] . '</div>';
                        }
                    }else{
                        echo '<div class="nota-individual">Alumno sin evaluar.</div>';
                    }
                    echo    '</div> 
                            <div class="asistencias">%'.$asistencias_alumno.'</div>
                            <div class="estado">'.$estado.'</div>
                        </div>';
                }
            
            ?>
        </div>

    </div>

</body>

<script src="../Resources/JS/boton.js"></script>

</html>

