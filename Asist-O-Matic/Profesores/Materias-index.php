<?php
    include_once '../Conexion.php';
    include_once '../Clases/Profesor.php';
    session_start();
    $rowprofesor = $_SESSION['rowprofesor'];

    if(isset($_POST['id-instituto'])){
        $_SESSION['id_instituto']=$_POST['id-instituto'];
    }

    $instituto_id = $_SESSION['id_instituto'];
    $id = $rowprofesor['id'];

    $materias_profesor = Profesor::mostrarMaterias($conexion,$id,$instituto_id);
?>

<!DOCTYPE html>
<html lang="en">
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
            <a href="funciones-profesor/inscribirse-materia.php"><img src="../Resources/Images/agregar materia.png" class="img-menu-admin"><span class="span-institutos">Materias</span></a>
            <a href="funciones-profesor/quitar-materia.php"><img src="../Resources/Images/quitar-materia.png" class="img-menu-admin"><span class="span-institutos">Materias</span></a>                
        </div>
        <div class="botton-div">
            <img class="image-div" src="../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>

<body>
    <div class="contenedores">
        <div class="top"><button class="button-back" onclick="redireccion(1)"></button><span class="titulo-encabezado">SELECCIONA LA MATERIA EN LA QUE DESEAS TOMAR ASISTENCIAS</span></div>
        
        <?php
            if (!$materias_profesor) {
                echo '<form action="funciones-profesor/inscribirse-materia.php" method="post">
                        <input type="submit" value="INSCRIBIRSE A UNA MATERIA" class="inscribirse-instituto">
                      </form>';
            } else {
                echo '<div class="container-institutos">'; 
                foreach ($materias_profesor as $materias) {
                    echo '<div class="instituto">
                            <form action="funciones-profesor/tomar-asistencia.php" method="post">
                                <input type="hidden" name="id-instituto" value="'.$instituto_id.'">
                                <input type="hidden" name="id-materia" value="'.$materias['id'].'">
                                <input class="button-instituto" type="submit" value="'.$materias['nombre'].'">
                            </form>
                          </div>';
                }
                echo '</div>'; 
            }
        ?>  
        <div class="bottom"></div>
    </div>
</body>
</html>
