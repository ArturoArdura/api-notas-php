<?php
$host = "localhost";
$db_name = "api_notas"; // El nombre que le diste en phpMyAdmin
$username = "root";     // Usuario por defecto en XAMPP
$password = "";         // Contraseña por defecto (vacía)

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Configurar para que nos muestre errores si algo falla
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Error de conexión: " . $exception->getMessage();
}
?>