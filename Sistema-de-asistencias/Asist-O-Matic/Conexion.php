<?php

$dsn = 'mysql:host=localhost;dbname=escueladb';
$usuario = 'root';
$contraseña = '';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,];

try {
    $conexion = new PDO($dsn, $usuario, $contraseña, $options);
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>  