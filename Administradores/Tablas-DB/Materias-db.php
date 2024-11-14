<?php
    require_once '../../Conexion.php';
    require_once '../../Clases/Materia.php';

    session_start();
    $row = $_SESSION['row'];

    // Manejo de la eliminación antes de cualquier salida HTML
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $sql = 
        "SELECT *
        FROM materias
        WHERE id = :id";

        $resultadosql = $conexion->prepare($sql);
        $resultadosql->bindParam(':id',$id);
        $resultadosql->execute();
        $materia = $resultadosql->fetch(PDO::FETCH_ASSOC);

        $administrador = new Materia($materia['nombre'],$materia['descripcion'],$materia['fecha_creacion'],$materia['codigo_mateia']);
        $administrador->eliminarMateria($conexion,$id);

        header("Location: Materias-db.php"); // Redirige a la misma página
        exit(); // Detiene la ejecución para evitar seguir enviando salida
    }


    $sql_admin = 
    "SELECT * 
    FROM materias";
    $resultado = $conexion->prepare($sql_admin);
    $resultado->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../../Resources/CSS/menu-desplegable.css">
    <link rel="stylesheet" href="../../Resources/CSS/Administrador/Administrador-db.css">
    <link rel="shortcut icon" href="../../Resources/Images/icono.png" sizes="64x64">
    <script src="../../Resources/JS/Menu.js"></script>
    <title>Materias</title>
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
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <span id="button" onclick="openNav()">&#9776;</span>
        <div class="cont-menu">
            <a href="../Administrador-index.php"><img src="../../Resources/Images/menu.png" class="img-menu"><span class="admin-span">Menu principal</span></a>
            <a href="Institutos-db.php"><img src="../../Resources/Images/instituto.png" class="img-menu-admin"><span class="span-institutos">Institutos</span></a>
            <a href="Profesores-db.php"><img src="../../Resources/Images/profesor.png" class="img-menu-admin"><span class="span-profesor">Profesores</span></a>
            <a href="Administradores-db.php"><img src="../../Resources/Images/gerente.png" class="img-menu-admin"><span class="span-administradores">Administradores</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/gerente.png" alt="">
            <span class="span-div"><?php echo  $row['nombre']." ".$row['apellido'] ?></span>
        </div>
    </div>
</div>
<body>
    <div class="contenedor">
        <div class="top-container"><span>MATERIAS</span></div>
        <div class="contenedor-info"><span class="id-top">ID</span><span class="nombre-materia-top">Nombre de la materia</span ><span class="descripcion-top">Descripcion</span><span class="fecha_cracion-top">Fecha de creacion</span ><span class="codigo_materia-top">Codigo de materia</span ><div class="boton-eliminar-top">¿Desea eliminar esta materia?</div></div>
        <?php
            while ($result = $resultado->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="contenedor-info">
                    <span class="id">' . $result['id'] . '</span>
                    <span class="nombre-materia">' . $result['nombre'] . '</span>
                    <span class="desccripcion">' . $result['descripcion'] . '</span>
                    <span class="fecha_creacion">' . $result['fecha_creacion'] . '</span>
                    <span class="codigo_materia">' . $result['codigo_materia'] . '</span>
                    <div class="boton-eliminar">
                        <form action="'.$_SERVER['PHP_SELF'].'" method="post" id="eliminar-admin">
                            <input type="hidden" name="id" value="' . $result['id'] . '">
                            <input type="button" class="eliminar-boton" value="Eliminar materia" onclick="Eliminartabla(this)">
                        </form>
                    </div>
                </div>';
            }
        ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../Resources/JS/administrador.js"></script>
</html>

