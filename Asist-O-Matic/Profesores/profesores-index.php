<?php
    include_once '../Clases/Profesor.php';
    include_once '../Conexion.php';
    session_start();

    $rowprofesor = $_SESSION['rowprofesor'];
    $id = $rowprofesor['id'];
    $profesor = new Profesor($rowprofesor['nombre'],$rowprofesor['apellido'],$rowprofesor['dni'],$rowprofesor['legajo']);
    $institutos_profesor = $profesor->institutosProfesor($conexion,$id)

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="../Resources/CSS/Profesor/profesor-index.css">
    <link rel="stylesheet" href="../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../Resources/CSS/menu-fijo.css">
    <link rel="shortcut icon" href="../Resources/Images/icono.png" sizes="64x64">
    <script src="../Resources/JS/Menu.js"></script>
    <script src="../Resources/JS/Profesor.js"></script>
</head>
<header class="encabezado">
    <img class="imagen-encabezado" src="../Resources/Images/director-de-escuela.png">
    <span class="bienvenido">Asist-o-Matic</span>

    <div class="container-button">
        <div><a href="../index.php"><img src="../Resources/Images/cerrar-sesion.png" class="img-session"><span class="span-sesion">CERRAR SESION</span></a></div>
    </div>
</header>

<div class="menu-container">
    <div id="mySidenav" class="sidenav">
        <div class="cont-menu">
            <a href="funciones-profesor/cambiar-parametros.php"><img src="../Resources/Images/parametros.png" class="img-menu-admin"><span class="span-parametros">Parametros</span></a>
            <a href="funciones-profesor/inscribirse-instituto.php"><img src="../Resources/Images/inscribir-instituto.png" class="img-menu-admin"><span class="span-institutos">Institutos</span></a>
            <a href="funciones-profesor/quitar-instituto.php"><img src="../Resources/Images/quitar-instituto.png" class="img-menu-admin"><span class="span-institutos">Institutos</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>

<body>
    <div class="contenedores">
        <div class="top"></button><span class="titulo-encabezado">SELECCIONA EL INSTITUTO EN EL QUE TE ENCUENTRAS</span></div>
        <div class="container-institutos">
            <?php
                if(!$institutos_profesor){
                    echo '<form action="funciones-profesor/inscribirse-instituto.php" method="post">
                            <input type="submit" value="INSCRIBIRSE A INSTITUTO" class="inscribirse-instituto">
                          </form>';
                }else{
                    foreach ($institutos_profesor as $instituto) {
                        echo '<div class="instituto"><form action="Materias-index.php" method="post"><input type="hidden" name="id-instituto" value="'.$instituto['id'].'"><input class="button-instituto" type="submit" value="'.$instituto['nombre'].'"></form></div>';
                    }
                }
            ?>
        </div>
        <div class="bottom"></div>
    </div>
</body>
</html>

