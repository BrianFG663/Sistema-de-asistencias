
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
<?php
    
    require_once 'Conexion.php';
    require_once 'Clases/Profesor.php';
    require_once 'Clases/Usuario.php';

    if(isset($_POST["login-name"]) &&!empty($_POST["login-name"]) && isset($_POST["login-pass"]) && !empty($_POST["login-pass"])){
        $mail = $_POST["login-name"];
        $contraseña = $_POST["login-pass"];

        $mail = htmlspecialchars($mail); 
        $contraseña = htmlspecialchars($contraseña);
        $mail = trim($mail); 
        $contraseña = trim($contraseña);

        $user = Usuario::getUser($conexion,$mail);

        if ($user) {
            if (password_verify($contraseña, $user['passw'])) {
                session_start();
                ob_clean();
                if ($user['rol'] == "administrador") {
                    $_SESSION['row'] = $user;
                    unset($_SESSION['rowprofesor']);
                    if ($contraseña == "admin") {
                        echo json_encode(['mensaje' => 'verdadero', 'url' => 'Cambio-contraseña.php']);
                    } else {
                        echo json_encode(['mensaje' => 'verdadero', 'url' => '/Administradores/Administrador-index.php']); //mando como url el url al que voy a redireccionar en js
                    }
                    exit();
        
                } elseif ($user['rol'] == "profesor") {
                    $_SESSION['rowuser'] = $user;
                    $id_profesor = $user['id_profesor'];
                    $row_profesor = Profesor::getProfesor($conexion, $id_profesor);
                    $_SESSION['rowprofesor'] = $row_profesor;
                    unset($_SESSION['row']);
        
                    if ($contraseña === $row_profesor['dni']) {
                        echo json_encode(['mensaje' => 'verdadero', 'url' => 'Cambio-contraseña.php']);
                    } else {
                        echo json_encode(['mensaje' => 'verdadero', 'url' => 'Profesores/profesores-index.php']);
                    }
                    exit();
                }
        
            } else {
                ob_clean();
                echo json_encode(['mensaje' => 'falso']);
                exit;
            }
        } else {
            ob_clean();
            echo json_encode(['mensaje' => 'mail-invalido']);
            exit;
        }
        
    }

?>
