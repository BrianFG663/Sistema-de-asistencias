
<?php

$host = 'localhost'; 
$db = 'escueladb'; 
$user = 'root'; 
$pass = ''; 



try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
    $pdo->exec("USE $db");

    $sqlinstituto = 
    "CREATE TABLE IF NOT EXISTS `instituto` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL,
    `direccion` varchar(255) NOT NULL,
    `cue` int NOT NULL,
    `gestion` enum('publico','privado') NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `cue` (`cue`)
    ) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
    
    $pdo->exec($sqlinstituto);

    $sqlalumno = 
    "CREATE TABLE IF NOT EXISTS `alumno` (
    `id` int NOT NULL AUTO_INCREMENT,
    `apellido` varchar(50) NOT NULL,
    `nombre` varchar(50) NOT NULL,
    `dni` varchar(20) NOT NULL,
    `fecha_nacimiento` date NOT NULL,
    `instituto_id` int NOT NULL,
    `estado` enum('desaprobado','regular','promocion','sin evaluar') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'sin evaluar',
    PRIMARY KEY (`id`),
    KEY `FK_alumno_instituto` (`instituto_id`),
    CONSTRAINT `FK_alumno_instituto` FOREIGN KEY (`instituto_id`) REFERENCES `instituto` (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlalumno);

    $sqlprofesor = 
    "CREATE TABLE IF NOT EXISTS `profesor` (
    `id` int NOT NULL AUTO_INCREMENT,
    `apellido` varchar(50) NOT NULL,
    `nombre` varchar(50) NOT NULL,
    `dni` varchar(20) NOT NULL,
    `legajo` varchar(20) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `dni` (`dni`),
    UNIQUE KEY `legajo` (`legajo`)
    ) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlprofesor);

    $sqlmateria = 
    "CREATE TABLE IF NOT EXISTS `materias` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) NOT NULL,
    `descripcion` text NOT NULL,
    `fecha_creacion` date NOT NULL,
    `codigo_materia` int NOT NULL,
    `profesor_id` int DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_materias_profesor` (`profesor_id`),
    CONSTRAINT `FK_materias_profesor` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlmateria);

    $sqlasistencias = 
    "CREATE TABLE IF NOT EXISTS `asistencias` (
    `id` int NOT NULL AUTO_INCREMENT,
    `alumno_id` int DEFAULT NULL,
    `fecha_asistencia` timestamp NOT NULL,
    `materia_id` int DEFAULT NULL,
    `valor` float NOT NULL,
    PRIMARY KEY (`id`),
    KEY `alumno_id` (`alumno_id`),
    KEY `FK_asistencias_materias` (`materia_id`),
    CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`) ON DELETE CASCADE,
    CONSTRAINT `FK_asistencias_materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlasistencias);

    $sqlinstituto_profesor = 
    "CREATE TABLE IF NOT EXISTS `instituto_profesor` (
    `id_profesor` int NOT NULL,
    `id_instituto` int NOT NULL,
    KEY `FK_instituto_profesor_instituto` (`id_instituto`),
    KEY `FK_instituto_profesor_profesor` (`id_profesor`),
    CONSTRAINT `FK_instituto_profesor_instituto` FOREIGN KEY (`id_instituto`) REFERENCES `instituto` (`id`) ON DELETE CASCADE,
    CONSTRAINT `FK_instituto_profesor_profesor` FOREIGN KEY (`id_profesor`) REFERENCES `profesor` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlinstituto_profesor);

    $sqlmateria_alumno = 
    "CREATE TABLE IF NOT EXISTS `materia_alumno` (
    `alumno_id` int NOT NULL,
    `materia_id` int NOT NULL,
    KEY `FK__alumno` (`alumno_id`),
    KEY `FK__materias` (`materia_id`),
    CONSTRAINT `FK__alumno` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`) ON DELETE CASCADE,
    CONSTRAINT `FK__materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlmateria_alumno);

    $sqlmateria_instituto = 
    "CREATE TABLE IF NOT EXISTS `materia_instituto` (
    `materia_id` int NOT NULL,
    `instituto_id` int NOT NULL,
    PRIMARY KEY (`materia_id`,`instituto_id`),
    KEY `instituto_id` (`instituto_id`),
    CONSTRAINT `materia_instituto_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
    CONSTRAINT `materia_instituto_ibfk_2` FOREIGN KEY (`instituto_id`) REFERENCES `instituto` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlmateria_instituto);

    $sqlnotas = 
    "CREATE TABLE IF NOT EXISTS `notas` (
    `id` int NOT NULL AUTO_INCREMENT,
    `alumno_id` int NOT NULL,
    `nota` float NOT NULL,
    `fecha_nota` date NOT NULL,
    `materia_id` int DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `alumno_id` (`alumno_id`),
    KEY `FK_notas_materias` (`materia_id`),
    CONSTRAINT `FK_notas_materias` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
    CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlnotas);

    $sqlram = 
    "CREATE TABLE IF NOT EXISTS `ram` (
    `regular` int NOT NULL DEFAULT '6',
    `promocion` int NOT NULL DEFAULT '7',
    `asistencias_regular` int NOT NULL DEFAULT '60',
    `asistencias_promocion` int NOT NULL DEFAULT '70',
    `fecha_funcionamiento` year NOT NULL,
    `instituto_id` int DEFAULT NULL,
    `tolerancia` int DEFAULT NULL,
    KEY `FK_ram_instituto` (`instituto_id`),
    CONSTRAINT `FK_ram_instituto` FOREIGN KEY (`instituto_id`) REFERENCES `instituto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlram);

    $sqlusuario = 
    "CREATE TABLE IF NOT EXISTS `usuario` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) NOT NULL,
    `apellido` varchar(50) NOT NULL,
    `mail` varchar(100) NOT NULL,
    `passw` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `rol` enum('administrador','profesor') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `id_profesor` int DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `mail` (`mail`),
    KEY `id_profesor` (`id_profesor`),
    CONSTRAINT `id_profesor` FOREIGN KEY (`id_profesor`) REFERENCES `profesor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

    $pdo->exec($sqlusuario);

    $nombre = 'Javier';
    $apellido = 'Parra';
    $mail = 'javier@gmail.com';
    $passw = '$2y$10$lbQze36Sp.NAo8GSM4YmCeQqTqunOAweCSQFsdAmQnyRPuj/yRm8.';
    $rol = 'administrador';
    $id_profesor = NULL;

    $sql_admin_verificacion = 
    "SELECT *
    FROM usuario
    WHERE mail = :mail";

    $resultado = $pdo->prepare($sql_admin_verificacion);
    $resultado->bindParam(':mail', $mail);
    $resultado->execute();

    $row = $resultado->fetch(PDO::FETCH_ASSOC);

    if(!$row){
        $sql = "INSERT INTO `usuario` (`nombre`, `apellido`, `mail`, `passw`, `rol`, `id_profesor`) 
        VALUES (:nombre, :apellido, :mail, :passw, :rol, :id_profesor)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':passw', $passw);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':id_profesor', $id_profesor);
        $stmt->execute();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar conexión
$pdo = null;
?>
