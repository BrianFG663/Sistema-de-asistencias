<?php
    require_once '../../Conexion.php';
    
    session_start();
    $row = $_SESSION['row'];

    // Busco en base de datos todas las instituciones 

    $institutos = 
    "SELECT id, nombre 
    FROM instituto";

    $resultado = $conexion->prepare($institutos);
    $resultado->execute();
    $institutos = $resultado->fetchall(PDO::FETCH_ASSOC)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar materia</title>
    <link rel="stylesheet" href="../../Resources/CSS/Administrador/Agregar-institutos.css">
    <link rel="stylesheet" href="../../Resources/CSS/Encabezado.css">
    <link rel="shortcut icon" href="../../Resources/Images/icono.png" sizes="64x64">
    <link rel="stylesheet" href="../../Resources/CSS/menu-fijo.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../Resources/JS/administrador.js"></script>
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
            <a href="agregar-instituto.php"><img src="../../Resources/Images/instituto.png" class="img-menu"><span>Agregar instituto</span></a>
            <a href="Agregar-profesor.php"><img src="../../Resources/Images/profesor.png" class="img-menu"><span>Agregar profesor</span></a>
            <a href="agregar-administrador.php"><img src="../../Resources/Images/gerente.png" class="img-menu"><span class="admin-span">Agregar admin</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/gerente.png" alt="">
            <span class="span-div"><?php echo $row['nombre']." ".$row['apellido'] ?></span>
        </div>
    </div>

</div>

<body>
    <div class="formulario-materia">
    <h2 class="title">AGREGAR MATERIA</h2>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" id="inscribir-materia">
            <label for="nombre_materia">Nombre de la materia</label>
            <input type="text" name="nombre_materia" id="nombre_materia" placeholder="Ingrese nombre de la materia" autocomplete="off">
            <label for="nombre_materia">Numero de la materia</label>
            <input type="text" name="numero_materia" id="numero_materia" placeholder="Ingrese numero de la materia" autocomplete="off">
            <label for="materia">Seleccione instituto en el que desea inscribir la materia:</label>
            <select name="instituto" id="instituto" class="styled-select"> <!-- Ingreso en el option las institutciones en base de datos buscadas anteriormente -->
                <?php

                foreach($institutos as $instituto){
                    echo '<option value="' . $instituto['id'] . '">' .$instituto['nombre']. '</option>';
                }
                ?>
            </select>
            <label for="descripcion_materia">Descripcion de la materia</label>
            <input type="text" name="descripcion_materia" id="descripcion_materia" placeholder="Escribe una breve descripcion de la materia" autocomplete="off">

            <div class="container-botones">
                <input type="button" value="Menu" id="boton_atras" onclick="redireccion(7)">
                <input type="button" value="Agregar materia" id="boton_agregar" name="boton_agregar" onclick="formularioMateria(2)">
            </div>
        </form>
    </div>
</body>

</html>
 
<?php
    include_once '../../Clases/Materia.php';
    include_once '../../Conexion.php';

    if(isset($_POST['nombre_materia']) && isset($_POST['descripcion_materia'])){
        $nombre = $_POST['nombre_materia'];
        $descripcion = $_POST['descripcion_materia'];
        $codigo_materia = $_POST['numero_materia'];
        $id_insituto = $_POST['instituto'];
        $fecha_actual = date("Y-m-d");



        $materia = new Materia($nombre,$descripcion,$fecha_actual,$codigo_materia,$id_insituto); 
        $result = $materia->comprobarMateria($conexion); //returna true o false dependiendo si la materia ya esta en BD

        if($result){ //en caso de retornar true se sube la materia a base de datos
            $materia->insertMateria($conexion,$id_insituto);

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