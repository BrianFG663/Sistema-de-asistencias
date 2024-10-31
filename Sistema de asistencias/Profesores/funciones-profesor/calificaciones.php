<?php
require_once '../../Conexion.php';
require_once '../../Clases/Profesor.php';
session_start();

$rowprofesor = $_SESSION['rowprofesor'];
$id_instituto = $_SESSION['id_instituto'];
$profesor = new Profesor($rowprofesor['nombre'],$rowprofesor['apellido'],$rowprofesor['dni'],$rowprofesor['legajo']);
$alumnos = $profesor->mostrarAlumnos($conexion,$_SESSION['id_materia'],$id_instituto);
?>

<?php
    require_once '../../Conexion.php';
    require_once '../../Clases/Instituto.php';
    require_once '../../Clases/Profesor.php';



    if (isset($_POST['notas'])) {
        $id_instituto = $_SESSION['id_instituto'];
        $materia_id = $_SESSION['id_materia'];
    
        $notas = $_POST['notas'];
        $ids = $_POST['id'];
        $tipo = intval($_POST['tipo-examen']);
        $fecha = $_POST["fecha"];
    

        $notas = $_POST['notas'];
        $ids = $_POST['id'];
        $tipo = $_POST['tipo-examen'];
    
        $notasFiltradas = [];
        $idsFiltrados = [];
    
        foreach ($notas as $index => $nota) {
            if (!empty($nota)) {
                $notasFiltradas[] = $nota;
                $idsFiltrados[] = $ids[$index];
            }
        }
    
        if($tipo == 1 || $tipo == 3){
            foreach($idsFiltrados as $index => $idsFiltrado){

                $sql_notas =
                "INSERT INTO notas(alumno_id,nota,fecha_nota,materia_id)
                VALUE(:alumno_id,:nota,:fecha_nota,:materia_id)";
    
                $resultado = $conexion->prepare($sql_notas);
                $resultado->bindParam(':alumno_id',$idsFiltrado);
                $resultado->bindParam(':nota',$notasFiltradas[$index]);
                $resultado->bindParam(':fecha_nota',$fecha);
                $resultado->bindParam(':materia_id',$materia_id);
                $resultado->execute();
            }

            ob_clean(); // limpio el boofer si no hago no funciona :)
            echo json_encode(['tipo' => 'normal', 'mensaje' => 'verdadero']);
            exit;
        }

        if($tipo == 2){
            $verificacion = Profesor::verificarCalificacion($conexion,$materia_id,$fecha);

            if($verificacion){
                foreach($idsFiltrados as $index => $idsFiltrado){

                    $sql_notas =
                    "UPDATE notas
                    SET nota = :nota
                    WHERE alumno_id = :alumno_id 
                        AND fecha_nota = :fecha_nota 
                        AND materia_id = :materia_id";
        
                    $resultado = $conexion->prepare($sql_notas);
                    $resultado->bindParam(':alumno_id',$idsFiltrado);
                    $resultado->bindParam(':nota',$notasFiltradas[$index]);
                    $resultado->bindParam(':fecha_nota',$fecha);
                    $resultado->bindParam(':materia_id',$materia_id);
                    $resultado->execute(); 
                }

                echo json_encode(['tipo' => 'recuperatorio', 'mensaje' => 'verdadero']); 
            }else{
                echo json_encode(['tipo' => 'recuperatorio', 'mensaje' => 'falso']);              
            }
            exit(); 
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="../../Resources/CSS/Profesor/alumno-index.css">
    <link rel="stylesheet" href="../../Resources/CSS/Encabezado.css">
    <link rel="stylesheet" href="../../Resources/CSS/menu-fijo.css">
    <link rel="shortcut icon" href="../../Resources/Images/icono.png" sizes="64x64">
    <script src="../../Resources/JS/Profesor.js"></script>

    <script src="../../Resources/JS/Menu.js"></script>
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
            <a href="tomar-asistencia.php"><img src="../../Resources/Images/tomar-asistencia.png" class="img-menu-admin"><span class="menu-span">Tomar asistencia</span></a>
            <a href="../estado-alumno.php"><img src="../../Resources/Images/graduado.png" class="img-menu-admin"><span class="alumno-span">Alumnos</span></a>
            <a href="crear-alumnos.php"><img src="../../Resources/Images/agregar alumno.png" class="img-menu-admin"><span class="agregar-alumno-span">Agregar alumno</span></a>
        </div>
        <div class="botton-div">
            <img class="image-div" src="../../Resources/Images/profesor.png">
            <span class="span-div"><?php echo  $rowprofesor['nombre']." ".$rowprofesor['apellido'] ?></span>
        </div>
    </div>
</div>



<body>
<div class="container">
        <div class="top"></button><span class="titulo">LISTADO DE ALUMNOS</span></div>
        <div class="container-alumnos">
            <form action="calificaciones.php" method="post" id="formulario-calificaciones"> 
                <?php
                    if (!$alumnos) {
                        echo '<input type="button" value="INSCRIBIR ALUMNOS" class="boton-inscribir-alumnos" onclick="redireccion(3)">';
                    } else {
                        echo'<div class="alumno-top"><div class="calificacion-top-nombre">NOMBRE COMPLETO</div><div class="calificacion-top-dni">DNI</div><div class="calificacion-top-fecha_nacimiento">FECHA DE NACIMIENTO</div><div class="calificacion-top-asistencia">INGRESAR NOTA</div></div>';
                        foreach($alumnos as $alumno){
                            echo '<div class="alumno">
                                    <div class="calificacion-nombre">'.$alumno['nombre']." ".$alumno['apellido'].'</div>
                                    <div class="calificacion-dni">'.$alumno['dni'].'</div>
                                    <div class="calificacion-fecha_nacimiento">'.$alumno['fecha_nacimiento'].'</div>
                                    <div class="calificacion-clasificacion">
                                        <input class="input-notas" id="notas" type="number" name="notas[]">
                                        <input type="hidden" name="id[]" value="'.$alumno['id'].'">
                                    </div>
                                </div>';
                        }
                    }
                ?>
        </div>

        <div class="container-botton">
        
            <div class="recuperatorio" id="recuperatorio">
                <div id="label-fecha">
                    <label for="fecha-recuperatorio">Fecha del parcial</label>
                </div>
                <input type="date" name="fecha" id="fecha">
            </div>

            <div id="error-dia">

            </div>

            <div class="select-contenedor">
                <label for="tipo-examen">Seleccione tipo de examen</label>
                <select class="select-tipo" name="tipo-examen" id="tipo-examen" onchange="mostrarLabel()">
                    <option value="1">PARCIAL</option>
                    <option value="2">RECUPERATORIO</option>
                    <option value="3">TRABAJO PRACTICO</option>
                </select>
            </div>
            
            <input class="subir-calificaciones" type="button" value="SUBIR CALIFICACIONES" onclick="formularioCalificaciones(this)">
            </form>

            
        </div>
</div>
</body>
</html>



