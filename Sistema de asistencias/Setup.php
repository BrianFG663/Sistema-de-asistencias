
<?php

$host = 'localhost'; 
$db = 'escueladb'; 
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_bd = 
    "SELECT SCHEMA_NAME 
    FROM INFORMATION_SCHEMA.SCHEMATA 
    WHERE SCHEMA_NAME = :bd";
    
    $resultado = $pdo->prepare($sql_bd);
    $resultado->bindParam(':bd', $bd);
    $resultado->execute();
    $row_bd = $resultado->fetch(PDO::FETCH_ASSOC);
    
    if(!$row_bd){
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

        $sql_insert_sedes = 
        "INSERT INTO `instituto` (`id`, `nombre`, `direccion`, `cue`, `gestion`)
        VALUES (115, 'SEDES', 'aaa', 2, 'privado')
        ON DUPLICATE KEY UPDATE `id` = VALUES(`id`)";

        $stmt = $pdo->prepare($sql_insert_sedes);
        $stmt->execute();
    
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

        $sql_insert_alumno = 
        "INSERT INTO alumno (id,nombre, apellido, fecha_nacimiento, dni, instituto_id, estado) VALUES 
        (1,'Valentino', 'Andrade', '1999-03-12', 35123456, 115, 'sin evaluar'),
        (2,'Lucas', 'Cedres', '1998-09-07', 34876543, 115, 'sin evaluar'),
        (3,'Facundo', 'Figun', '2000-11-25', 40123789, 115, 'sin evaluar'),
        (4,'Luca', 'Giordano', '1997-06-02', 32456789, 115, 'sin evaluar'),
        (5,'Bruno', 'Godoy', '1999-01-18', 36789123, 115, 'sin evaluar'),
        (6,'Agustin', 'Gomez', '1996-04-30', 33567890, 115, 'sin evaluar'),
        (7,'Brian', 'Gonzalez', '1997-12-05', 35678901, 115, 'sin evaluar'),
        (8,'Federico', 'Guigou Scottini', '1998-08-15', 37890123, 115, 'sin evaluar'),
        (9,'Luna', 'Marrano', '1999-03-10', 38901234, 115, 'sin evaluar'),
        (10,'Giuliana', 'Mercado Aviles', '1995-10-22', 33345678, 115, 'sin evaluar'),
        (11,'Lucila', 'Mercado Ruiz', '1996-12-08', 32567890, 115, 'sin evaluar'),
        (12,'Angel', 'Murillo', '1998-02-27', 34890123, 115, 'sin evaluar'),
        (13,'Juan', 'Nissero', '1999-07-17', 36123456, 115, 'sin evaluar'),
        (14,'Fausto', 'Parada', '1997-11-06', 35234567, 115, 'sin evaluar'),
        (15,'Ignacio', 'Piter', '1996-05-19', 32789012, 115, 'sin evaluar'),
        (16,'Tomas', 'Planchon', '2000-09-03', 40456789, 115, 'sin evaluar'),
        (17,'Elisa', 'Ronconi', '1995-01-24', 31678123, 115, 'sin evaluar'),
        (18,'Exequiel', 'Sanchez', '1998-04-11', 33234567, 115, 'sin evaluar'),
        (19,'Melina', 'Schimpf Baldo', '1996-10-09', 33789456, 115, 'sin evaluar'),
        (20,'Diego', 'Segovia', '1997-02-13', 34567890, 115, 'sin evaluar'),
        (21,'Camila', 'Sittner', '1999-08-20', 36456789, 115, 'sin evaluar'),
        (22,'Yamil', 'Villa', '1998-06-28', 35345678, 115, 'sin evaluar')
        ON DUPLICATE KEY UPDATE `id` = VALUES(`id`)";

        $stmt = $pdo->prepare($sql_insert_alumno);
        $stmt->execute();
    
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

        $sql_insert_materia = 
        "INSERT INTO `materias` (`id`, `nombre`, `descripcion`, `fecha_creacion`, `codigo_materia`) 
        VALUES(1, 'PROGRAMACION II', 'PROGRAMACION II', '2024-09-27', 1)
        ON DUPLICATE KEY UPDATE `codigo_materia` = `codigo_materia`";

        $pdo->exec($sql_insert_materia);
    
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

        $insert_materia_alumno = 
        "INSERT INTO materia_alumno (alumno_id, materia_id) VALUES 
        (1, 1),(2, 1),(3, 1),(4, 1),(5, 1),(6, 1),(7, 1),(8, 1),(9, 1),(10, 1),(11, 1),(12, 1),(13, 1),(14, 1),(15, 1),(16, 1),(17, 1),(18, 1),(19, 1),(20, 1),(21, 1),(22, 1)
        ON DUPLICATE KEY UPDATE `alumno_id` = `alumno_id`";

        $stmt = $pdo->prepare($insert_materia_alumno);
        $stmt->execute();
    
        $sqlmateria_instituto = 
        "CREATE TABLE IF NOT EXISTS `materia_instituto` (
        `materia_id` int NOT NULL,
        `instituto_id` int NOT NULL,
        PRIMARY KEY (`materia_id`,`instituto_id`),
        KEY `instituto_id` (`instituto_id`),
        CONSTRAINT `materia_instituto_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
        CONSTRAINT `materia_instituto_ibfk_2` FOREIGN KEY (`instituto_id`) REFERENCES `instituto` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";
    
        $pdo->exec($sqlmateria_instituto);

        $insert_materia_instituto = 
        "INSERT INTO `materia_instituto` (`materia_id`, `instituto_id`) 
        VALUES(1, 115)
        ON DUPLICATE KEY UPDATE `materia_id` = `materia_id`";

        $stmt = $pdo->prepare($insert_materia_instituto);
        $stmt->execute();
    
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
        `instituto_id` int NOT NULL,
        `tolerancia` int DEFAULT NULL,
        PRIMARY KEY (`instituto_id`),  -- Define `instituto_id` como clave primaria
        CONSTRAINT `FK_ram_instituto` FOREIGN KEY (`instituto_id`) REFERENCES `instituto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
    
        $pdo->exec($sqlram);

        $inser_ram_sedes =
        "INSERT INTO `ram` (`regular`, `promocion`, `asistencias_regular`, `asistencias_promocion`, `fecha_funcionamiento`, `instituto_id`, `tolerancia`) 
        VALUES(6, 6, 60, 70, '2024', 115, 1)
        ON DUPLICATE KEY UPDATE `instituto_id` = `instituto_id`";

        $pdo->exec($inser_ram_sedes);
    
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
    }
   

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar conexión
$pdo = null;
?>
