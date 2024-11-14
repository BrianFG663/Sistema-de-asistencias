<?php
    include_once '../../Conexion.php';
    require_once '../../Clases/Profesor.php';
    require_once '../../Clases/Alumno.php';
    session_start();

    $rowprofesor = $_SESSION['rowprofesor'];
    if(isset($_POST["id_alumno"])){
        $id = $_POST["id_alumno"];
        $_SESSION["id_alumno"] = $id;
        $alumno = Alumno::getAlumno($conexion,$id);
    }

    $institutos = Profesor::institutosProfesor($conexion,$id);

    
?>

<?php

$actualizado = false;

if(isset($_POST['nombre-alumno']) && !empty($_POST['nombre-alumno'])){
        
    $nombre_alumno = $_POST['nombre-alumno'];
    $id = $_SESSION["id_alumno"];

    $sql_parametros = 
    "UPDATE alumno 
    SET nombre = :nombre
    WHERE id = :id";

    $resultado = $conexion->prepare($sql_parametros);
    $resultado->bindParam(':nombre',$nombre_alumno);
    $resultado->bindParam(':id',$id);
    $resultado->execute();

    $actualizado = true;
}

if(isset($_POST['apellido-alumno']) && !empty($_POST['apellido-alumno'])){
        
    $apellido_alumno = $_POST['apellido-alumno'];
    $id = $_SESSION["id_alumno"];


    $sql_parametros = 
    "UPDATE alumno 
    SET apellido = :apellido
    WHERE id = :id";

    $resultado = $conexion->prepare($sql_parametros);
    $resultado->bindParam(':apellido',$apellido_alumno);
    $resultado->bindParam(':id',$id);
    $resultado->execute();

    $actualizado = true;

}

if(isset($_POST['dni-alumno']) && !empty($_POST['dni-alumno'])){
        
    $dni_alumno = $_POST['dni-alumno'];
    $id = $_SESSION["id_alumno"];


    $sql_parametros = 
    "UPDATE alumno 
    SET dni = :dni
    WHERE id = :id";

    $resultado = $conexion->prepare($sql_parametros);
    $resultado->bindParam(':dni',$dni_alumno);
    $resultado->bindParam(':id',$id);
    $resultado->execute();


    $actualizado = true;
}

if(isset($_POST['fecha-alumno']) && !empty($_POST['fecha-alumno'])){
        
    $nacimiento_alumno = $_POST['fecha-alumno'];
    $id = $_SESSION["id_alumno"];


    $sql_parametros = 
    "UPDATE alumno 
    SET fecha_nacimiento = :fecha_nacimiento
    WHERE id = :id";

    $resultado = $conexion->prepare($sql_parametros);
    $resultado->bindParam(':fecha_nacimiento',$nacimiento_alumno);
    $resultado->bindParam(':id',$id);
    $resultado->execute();

    $actualizado = true;

}

if ($actualizado) {
    header("Location: editar-alumno.php?success=true");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar alumno</title>
    <link rel="shortcut icon" href="../../Resources/Images/icono.png" sizes="64x64">
    <link rel="stylesheet" href="../../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../../Resources/CSS/Administrador/Agregar-profesor.css">
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
            <a href="../estado-alumno.php"><img src="../../Resources/Images/graduado.png" class="img-menu-admin"><span class="alumno-span">Alumnos</span></a>
            <a href="eliminar-alumnos.php"><img src="../../Resources/Images/eliminar-alumno.png" class="img-menu-admin"><span class="agregar-alumno-span">eliminar alumno</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>

<body>

    <div class="contenedor-editar-alumno">
        <span class="titulo-edicion">ALUMNO EN EDICION</span>
    <div class="alumno-top"><div class="top-id">ID</div><div class="top-nombre">NOMBRE COMPLETO</div><div class="top-dni">DNI</div><div class="top-fecha_nacimiento">FECHA DE NACIMIENTO</div></div>
    <?php

if (isset($_SESSION['id_alumno'])) {
    $id_alumno = $_SESSION['id_alumno'];
    $alumno = Alumno::getAlumno($conexion, $id_alumno);
    
    if ($alumno) {
        echo '<div class="alumno">';
        echo '<div class="id">' . $alumno['id'] . '</div>';
        echo '<div class="nombre">' . $alumno['nombre'] . ' ' . $alumno['apellido'] . '</div>';
        echo '<div class="dni">' . $alumno['dni'] . '</div>';
        echo '<div class="fecha_nacimiento">' . $alumno['fecha_nacimiento'] . '</div>';
        echo '</div>';
    }
}

    ?>
    </div>

    <div class="formulario-editar-alumno">
    <h2 class="title">EDITAR ALUMNO</h2>
        <form action="Procesar-editar-alumno.php" method="post" id="editar-alumno">
            <div class="container">
                <div class="container-input">
                    <label for="">Nombre:</label>
                    <input type="text" name="nombre-alumno" id="nombre-alumno" placeholder="Ingrese nombre" autocomplete="off">
                    <label for="">Apellido</label>
                    <input type="text" name="apellido-alumno" id="apellido-alumno" placeholder="Ingrese apellido" autocomplete="off">
                </div>

                <div class="container-input">
                    <label for="">DNI</label>
                    <input type="text" name="dni-alumno" id="dni-alumno" placeholder="Ingrese DNI" autocomplete="off">
                    <label for="">Fecha de nacimiento</label>
                    <input type="date" name="fecha-alumno" id="fecha-alumno" placeholder="Ingrese fecha de nacimiento" autocomplete="off">
                </div>
            </div>
        
            <div class="container-botones">
                <input type="button" value="Menu" id="boton_atras" onclick="redireccion(4)">
                <input type="button" value="Editar alumno" id="boton_agregar" name="boton_agregar" onclick="formularioEditarAlumno()">
            </div>
        </form>
    </div>
</body>
</html>
