<?php
session_start();
$row = $_SESSION['row'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar profesor</title>
    <link rel="shortcut icon" href="../../Resources/Images/icono.png" sizes="64x64">
    <link rel="stylesheet" href="../../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../../Resources/CSS/Administrador/Agregar-profesor.css">
    <link rel="stylesheet" href="../../Resources/CSS/menu-fijo.css">

    <script src="../../Resources/JS/administrador.js"></script>
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
            <a href="../Administrador-index.php"><img src="../../Resources/Images/menu.png" class="img-menu"><span class="admin-span">Menu principal</span></a>
            <a href="Agregar-materia.php"><img src="../../Resources/Images/libros.png" class="img-menu"><span>Agregar materia</span></a>
            <a href="agregar-instituto.php"><img src="../../Resources/Images/instituto.png" class="img-menu"><span>Agregar instituto</span></a>
            <a href="agregar-administrador.php"><img src="../../Resources/Images/gerente.png" class="img-menu"><span class="admin-span">Agregar admin</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/gerente.png" alt="">
            <span class="span-div"><?php echo  $row['nombre']." ".$row['apellido'] ?></span>
        </div>
    </div>
</div>

<body>
    <div class="formulario-materia">
    <h2 class="title">INSCRIBIR PROFESOR</h2>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" id="inscribir-profesor">
            <div class="container">
                <div class="container-input">
                    <label for="">Nombre:</label>
                    <input type="text" name="nombre-profesor" id="nombre-profesor" placeholder="Ingrese nombre" autocomplete="off">
                    <label for="">Apellido</label>
                    <input type="text" name="apellido-profesor" id="apellido-profesor" placeholder="Ingrese apellido" autocomplete="off">
                </div>
                <div class="container-input">
                    <label for="">Correo electronico</label>
                    <input type="text" name="correo-profesor" id="correo-profesor" placeholder="Ingrese correo E-mail" autocomplete="off">
                    <label for="">Legajo</label>
                    <input type="number" name="legajo-profesor" id="legajo-profesor" placeholder="ingrese legajo" autocomplete="off">
                </div>
                <div class="container-dni">
                    <label for="">DNI</label>
                    <input type="number" name="dni-profesor" id="dni-profesor" placeholder="Ingrese DNI" autocomplete="off">
                </div>
            </div>
        
            <div class="container-botones">
                <input type="button" value="Menu" id="boton_atras" onclick="redireccion(7)">
                <input type="button" value="Agregar profesor" id="boton_agregar" name="boton_agregar" onclick="formularioProfesor()">
            </div>
        </form>
    </div>
</body>

</html>

<?php

    include_once '../../Clases/Profesor.php';
    include_once '../../Clases/Usuario.php';
    include_once '../../Conexion.php';

    if(isset($_POST['nombre-profesor'])){
        $nombre = $_POST['nombre-profesor'];
        $apellido = $_POST['apellido-profesor'];
        $dni = $_POST['dni-profesor'];
        $mail = $_POST['correo-profesor'];
        $legajo = $_POST['legajo-profesor'];
        $pass = $_POST['dni-profesor'];
        $rol = "profesor";

        $profesor = new Profesor($nombre,$apellido,$dni,$legajo);
        $usuario = new Usuario($nombre,$apellido,$mail,$pass,$rol);
        $comprobarMail = $usuario->comprobarMail($conexion,$mail);
        $comprobarDni =  $profesor->comprobarDni($conexion);
        $comprobarlegajo = $profesor->comprobarlegajo($conexion);

        if($comprobarMail){
            if($comprobarDni){
                if($comprobarlegajo){
                    $profesor->insertProfesor($conexion,$mail);
                    $usuario->insertUserProfesor($conexion,$dni);

                    ob_clean();
                    echo json_encode(['mensaje' => 'verdadero']);
                    exit;
    
                }else{

                    ob_clean();
                    echo json_encode(['mensaje' => 'false-legajo']);
                    exit;

                }
            }else{

                ob_clean();
                echo json_encode(['mensaje' => 'false-dni']);
                exit;

            }

        }else{

            ob_clean();
            echo json_encode(['mensaje' => 'false-mail']);
            exit;

        }



    }

?>