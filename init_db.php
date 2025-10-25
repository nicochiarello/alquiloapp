<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'alquiloapp';

// --- 1. Local conection. ---
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// --- 2. Create database if not exists ---
$sql = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if ($conn->query($sql) === TRUE) {
    echo "✅ Base de datos '$dbName' lista.<br>";
} else {
    die("❌ Error al crear base de datos: " . $conn->error);
}

// --- 3. Select the database ---
$conn->select_db($dbName);

// --- 4. Create the table property ---
$tableSql = "
CREATE TABLE IF NOT EXISTS property (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(120) NOT NULL,
  type ENUM('rent','sale') NOT NULL,
  price INT NOT NULL DEFAULT 0,
  location VARCHAR(255) NOT NULL,
  area INT NOT NULL DEFAULT 0,
  beds INT NOT NULL DEFAULT 0,
  baths INT NOT NULL DEFAULT 0,
  garage TINYINT(1) NOT NULL DEFAULT 0,
  description TEXT NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

if ($conn->query($tableSql) === TRUE) {
    echo "✅ Tabla 'property' creada o ya existente.<br>";
} else {
    die("❌ Error al crear tabla: " . $conn->error);
}

// --- Create the table users ---
$tableSql = "
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(20) NOT NULL,
  name VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

if ($conn->query($tableSql) === TRUE) {
    echo "✅ Tabla 'users' creada o ya existente.<br>";
} else {
    die("❌ Error al crear tabla: " . $conn->error);
}

echo "✅ Inicialización completa.<br>";

// --- 5. Close connection ---
$conn->close();
?>
