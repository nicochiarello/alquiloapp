<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'alquiloapp';

// Crear conexión
$conn = new mysqli($host, $user, $pass, $dbName);

// if the connection fails, show an error message
if ($conn->connect_errno) {
    die("❌ Error al conectar con MySQL: " . $conn->connect_error);
}

// Set charset to utf8mb4 (to support emojis and special characters)
$conn->set_charset('utf8mb4');
?>