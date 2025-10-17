<?php
session_start();

require_once("../db.php");

// --- Read inputs ---
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$pass  = isset($_POST['password']) ? $_POST['password'] : '';

// --- Validate inputs ---
$fieldErrors = [];   // field -> message
$errors = [];        // general messages

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $fieldErrors['email'] = "Email inválido.";
}
if ($pass === '' || strlen($pass) < 8) {
  $fieldErrors['password'] = "La contraseña debe tener al menos 8 caracteres.";
}

if (!empty($fieldErrors)) {
  $qs = http_build_query([
    'field_errors' => $fieldErrors,
    'errors' => ["Revisá los campos e intentá de nuevo."],
    'old' => ['email' => $email],
  ]);
  header("Location: /alquiloapp/login.php?$qs");
  exit;
}

// --- Fetch user by email ---
$stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

$user = $res->fetch_assoc();
$stmt->close();

// --- Check credentials ---
if (!$user || !password_verify($pass, $user['password'])) {
  $qs = http_build_query([
    'errors' => ["Credenciales inválidas."],
    'old' => ['email' => $email],
  ]);
  header("Location: /alquiloapp/login.php?$qs");
  exit;
}

// --- Ok: set session ---
$_SESSION['user_id']    = (int)$user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_name']  = $user['name'];
session_regenerate_id(true);

// --- Redirect (dashboard/home) ---
header("Location: /alquiloapp/dashboard.php");
exit;
