<?php
    include_once '../../Conexion.php';
    require_once '../../Clases/Profesor.php';
    session_start();

    $rowprofesor = $_SESSION['rowprofesor'];
    $id = $rowprofesor['id'];
    $institutos = Profesor::institutosProfesor($conexion,$id);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="../../Resources/CSS/Profesor/parametros.css">
    <link rel="stylesheet" href="../../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../../Resources/CSS/menu-fijo.css">
    <link rel="shortcut icon" href="../Resources/Images/icono.png" sizes="64x64">
    <script src="../../Resources/JS/Menu.js"></script>
    <script src="../../Resources/JS/Profesor.js"></script>
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
            <a href="inscribirse-instituto.php"><img src="../../Resources/Images/inscribir-instituto.png" class="img-menu-admin"><span class="span-institutos">Institutos</span></a>
            <a href="quitar-instituto.php"><img src="../../Resources/Images/quitar-instituto.png" class="img-menu-admin"><span class="span-institutos">Institutos</span></a>

        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>

<body> 
    <form action="cambiar-parametros.php" method="post" class="container" id="formulario-parametros">
        <div class="encabezado-contenedor">CAMBIAR PARAMETROS</div>
        <div class="container-container">
            <div class="container-input">

                <label for="regular">Nota minima para alumno regular:</label>
                <input type="number" name="regular" id="regular">
                <label for="promocion">Nota minima para alumno promocionado:</label>
                <input type="number" name="promocion" id="promocion">
                <label for="asistencia-regular">Porcentaje de asistencias para alumnos regulares:</label>
                <input type="number" name="asistencia-regular" id="asistencia-regular">
            </div>
            <div class="container-input">
                <label for="asistencia-promocion">Porcentaje de asistencias para alumnos promocionados:</label>
                <input type="number" name="asistencia-promocion" id="asistencia-promocion">
                <label for="tolerancia">Tolerancia de llegada/salida</label>
                <input type="number" name="tolerancia" id="tolerancia">
                <label for="instituto-select">SELECCIONA INSTITUTO PARA LOS PARAMETROS</label>
                <select name="instituto-select" id="instituto-select">
                <?php
                    foreach($institutos as $instituto){
                        echo '<option value="'.$instituto['id'].'">'.$instituto['nombre'].'</option>';
                    }
                ?>
                </select>
            </div>
        </div>

        <div class="contenedor-tres">
            <input type="button" value="Cambiar parametros" class="cambiar-parametros" onclick="formularioParametros()">
        </div>
    </form>
</body>
</html>

<?php

    if(isset($_POST['regular']) && !empty($_POST['regular'])){
        
        $regular = intval($_POST['regular']);
        $instituto_id = intval($_POST['instituto-select']);

        $sql_parametros = 
        "UPDATE ram 
        SET regular = :regular
        WHERE instituto_id = :instituto_id";
    
        $resultado = $conexion->prepare($sql_parametros);
        $resultado->bindParam(':regular',$regular);
        $resultado->bindParam(':instituto_id',$instituto_id);
        $resultado->execute();
    }

    if(isset($_POST['promocion']) && !empty($_POST['promocion'])){
        
        $promocion = intval($_POST['promocion']);
        $instituto_id = intval($_POST['instituto-select']);

        $sql_parametros = 
        "UPDATE ram 
        SET promocion = :promocion
        WHERE instituto_id = :instituto_id";
    
        $resultado = $conexion->prepare($sql_parametros);
        $resultado->bindParam(':instituto_id',$instituto_id);
        $resultado->bindParam(':promocion',$promocion);
        $resultado->execute();
    }

        if(isset($_POST['asistencia-regular']) && !empty($_POST['asistencia-regular'])){
        
        $asistencia_regular = intval($_POST['asistencia-regular']);
        $instituto_id = intval($_POST['instituto-select']);


        $sql_parametros = 
        "UPDATE ram 
        SET asistencias_regular = :asistencia_regular
        WHERE instituto_id = :instituto_id";
    
        $resultado = $conexion->prepare($sql_parametros);
        $resultado->bindParam(':asistencia_regular',$asistencia_regular);
        $resultado->bindParam(':instituto_id',$instituto_id);

        $resultado->execute();
    }

    if(isset($_POST['asistencia-promocion']) && !empty($_POST['asistencia-promocion'])){
        
        $asistencia_promocion = intval($_POST['asistencia-promocion']);
        $instituto_id = intval($_POST['instituto-select']);

        $sql_parametros = 
        "UPDATE ram 
        SET asistencias_promocion = :asistencia_promocion
        WHERE instituto_id = :instituto_id";
    
        $resultado = $conexion->prepare($sql_parametros);
        $resultado->bindParam(':asistencia_promocion',$asistencia_promocion);
        $resultado->bindParam(':instituto_id',$instituto_id);
        $resultado->execute();
    }

    if(isset($_POST['tolerancia']) && !empty($_POST['tolerancia'])){
        
        $tolerancia = intval($_POST['tolerancia']);
        $instituto_id = intval($_POST['instituto-select']);

        $sql_parametros = 
        "UPDATE ram 
        SET tolerancia = :tolerancia
        WHERE instituto_id = :instituto_id";
    
        $resultado = $conexion->prepare($sql_parametros);
        $resultado->bindParam(':tolerancia',$tolerancia);
        $resultado->bindParam(':instituto_id',$instituto_id);
        $resultado->execute();
    }
?>

