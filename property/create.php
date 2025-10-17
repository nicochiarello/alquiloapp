<?php

session_start();

require_once __DIR__ . '/../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    // Not logged in, redirect to login
    header("Location: /alquiloapp/login.php");

    exit;
}

$user_id = $_SESSION['user_id'];
$title = $_POST['title'] ?? '';
$type = $_POST['type'] ?? 'rent'; // rent|sale
$price = (int) ($_POST['price'] ?? 0);
$location = $_POST['location'] ?? '';
$area = (int) ($_POST['area'] ?? 0);
$beds = (int) ($_POST['beds'] ?? 0);
$baths = (int) ($_POST['baths'] ?? 0);
$garage = isset($_POST['garage']) ? 1 : 0;
$description = $_POST['description'] ?? '';
$imagePath = null;

// Image upload
if (!empty($_FILES['image']['name'])) {
    $uploadsDir = __DIR__ . '/../uploads';
    if (!is_dir($uploadsDir)) {
        @mkdir($uploadsDir, 0775, true);
    }
    $basename = basename($_FILES['image']['name']);
    // Simplme name
    $target = $uploadsDir . '/' . time() . '_' . preg_replace('/\s+/', '_', $basename);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Relative path to serve later
        $imagePath = 'uploads/' . basename($target);
    }
}

// Insert into database
$sql = "INSERT INTO property
(user_id, title, type, price, location, area, beds, baths, garage, description, image)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    'ississiiiss',
    $user_id,
    $title,
    $type,
    $price,
    $location,
    $area,
    $beds,
    $baths,
    $garage,
    $description,
    $imagePath
);

$stmt->execute();
$stmt->close();
$conn->close();

// Redirect to dashboard with success message
header('Location: /alquiloapp/dashboard.php?created=1');
exit;
