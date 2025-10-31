<?php
session_start();

include("../db_connect.php");

// --- Read & sanitize inputs ---
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$pass1 = isset($_POST['password']) ? $_POST['password'] : '';
$pass2 = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Input validation
$fieldErrors = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $fieldErrors['email'] = "Email inválido.";
}
if ($name === '' || mb_strlen($name) > 100) {
    $fieldErrors['name'] = "Nombre requerido (máx. 100 caracteres).";
}
if ($phone === '' || mb_strlen($phone) > 20) {
    $fieldErrors['phone'] = "Teléfono requerido (máx. 20 caracteres).";
}
if (strlen($pass1) < 8) {
    $fieldErrors['password'] = "La contraseña debe tener al menos 8 caracteres.";
}
if ($pass1 !== $pass2) {
    $fieldErrors['confirm_password'] = "Las contraseñas no coinciden.";
}

if (!empty($fieldErrors)) {
    $qs = http_build_query([
        'errors' => $fieldErrors,
    ]);
    header("Location: /alquiloapp/register.php?$qs");
    exit;
}


// --- Check duplicate email ---
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    $check->close();
    http_response_code(409);
    echo "<p>Ese email ya está registrado.</p><a href=\"/register.html\">Volver</a>";
    exit;
}
$check->close();

// --- Insert user (password hashed) ---
$hash = password_hash($pass1, PASSWORD_DEFAULT);

$ins = $conn->prepare("INSERT INTO users (email, phone, name, password) VALUES (?, ?, ?, ?)");
$ins->bind_param("ssss", $email, $phone, $name, $hash);

if (!$ins->execute()) {
    http_response_code(500);
    echo "Error al registrar el usuario.";
    exit;
}

$userId = $ins->insert_id;
$ins->close();

// --- Set session and redirect ---
$_SESSION['user_id'] = $userId;
$_SESSION['user_email'] = $email;
$_SESSION['user_name'] = $name;

// Redirect to a dashboard/home page after register
header("Location: /alquiloapp/dashboard.php");


exit;
