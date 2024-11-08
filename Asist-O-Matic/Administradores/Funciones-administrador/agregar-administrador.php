<?php
    session_start();
    $row = $_SESSION['row'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="../../Resources/Images/icono.png" sizes="64x64">
    <link rel="stylesheet" href="../../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../../Resources/CSS/Administrador/Agregar-profesor.css">
    <link rel="stylesheet" href="../../Resources/CSS/menu-fijo.css">
    <script src="../../Resources/JS/administrador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<header class="encabezado">
    <a href="../Administrador-index.php"><img class="imagen-encabezado" src="../../Resources/Images/director-de-escuela.png"></a>
    <a href="../Administrador-index.php"><span class="bienvenido">Asist-o-Matic</span></a>

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
            <a href="Agregar-profesor.php"><img src="../../Resources/Images/profesor.png" class="img-menu"><span>Agregar profesor</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/gerente.png" alt="">
            <span class="span-div"><?php echo $row['nombre']." ".$row['apellido'] ?></span>
        </div>
    </div>

</div>

<body>

    <div class="mensaje">
        <img src="../../Resources/Images/recordatorio.png" alt="">
        <span>Recordatorio: su contraseña inicial sera "admin"</span>
    </div>

    <div class="formulario-administrador">
    <h2 class="title">INSCRIBIR ADMINISTRADOR</h2>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" id="inscribir-administrador">
            <div class="container">
                <div class="container-input">
                    <label for="">Nombre:</label>
                    <input type="text" name="nombre-administrador" id="nombre-administrador" placeholder="Ingrese nombre" autocomplete="off">
                    <label for="">Apellido</label>
                    <input type="text" name="apellido-administrador" id="apellido-administrador" placeholder="Ingrese apellido" autocomplete="off">
                    <label for="">Correo electronico</label>
                    <input type="text" name="correo-administrador" id="correo-administrador" placeholder="Ingrese correo E-mail" autocomplete="off">
                </div>
            </div>
            <div class="container-botones">
                <input type="button" value="Menu" id="boton_atras" onclick="redireccion(7)">
                <input type="button" value="Agregar administrador" id="boton_agregar" name="boton_agregar" onclick="formularioAdministrador()">
            </div>
        </form>
    </div>
</body>

</html>

<?php

    include_once '../../Clases/Usuario.php';
    include_once '../../Conexion.php';

    if(isset($_POST['nombre-administrador'])){
        $nombre = $_POST['nombre-administrador'];
        $apellido = $_POST['apellido-administrador'];
        $mail = $_POST['correo-administrador'];
        $pass = $_POST['nombre-administrador'];
        $rol = "administrador";


        $usuario = new Usuario($nombre,$apellido,$mail,$pass,$rol);
        $comprobarMail = $usuario->comprobarMail($conexion,$mail);

        if($comprobarMail){
            $usuario->insertUserAdmin($conexion);

            ob_clean();
            echo json_encode(['mensaje' => 'verdadero']);
            exit;

        }else{

            ob_clean();
            echo json_encode(['mensaje' => 'falso']);
            exit;

        }



    }

?>