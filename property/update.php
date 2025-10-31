<?php
session_start();
require_once __DIR__ . '/../db_connect.php';

// --- Read POST ---
$id          = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title       = $_POST['title'] ?? '';
$type        = $_POST['type'] ?? '';
$price       = (int)($_POST['price'] ?? 0);
$location    = $_POST['location'] ?? '';
$area        = (int)($_POST['area'] ?? 0);
$beds        = (int)($_POST['beds'] ?? 0);
$baths       = (int)($_POST['baths'] ?? 0);
$garage      = isset($_POST['garage']) ? 1 : 0;
$description = $_POST['description'] ?? '';
$imageOld    = $_POST['image_old'] ?? ''; // relative path
$imagePath   = ''; // new uploaded path (if any)

if ($id <= 0) {
  http_response_code(400);
  exit('Invalid id');
}

// --- Image replacement ---
if (!empty($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
    $uploadsDir = __DIR__ . '/../uploads';
    if (!is_dir($uploadsDir)) {
        @mkdir($uploadsDir, 0775, true);
    }

    $original = $_FILES['image']['name'];
    $ext = pathinfo($original, PATHINFO_EXTENSION);
    $fname = 'prop_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . ($ext ? ('.'.$ext) : '');
    $destAbs = $uploadsDir . '/' . $fname;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $destAbs)) {
        $imagePath = 'uploads/' . $fname;

        // remove old file if it existed and looks local
        if (!empty($imageOld)) {
            $base = realpath(__DIR__ . '/..'); // project root
            $oldAbs = realpath($base . '/' . $imageOld);
            if ($oldAbs && strpos($oldAbs, $base) === 0 && @is_file($oldAbs)) {
                @unlink($oldAbs);
            }
        }
    }
}

// --- Build and run UPDATE ---
if ($imagePath !== '') {
    // Update including new image
    $sql = "UPDATE property
            SET title=?, type=?, price=?, location=?, area=?, beds=?, baths=?, garage=?, description=?, image=?, updated_at=CURRENT_TIMESTAMP
            WHERE id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        exit('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param(
        'ssissiiissi',
        $title,       
        $type,        
        $price,       
        $location,   
        $area,    
        $beds,       
        $baths,      
        $garage,   
        $description, 
        $imagePath,  
        $id          
    );
} else {
    // Update without touching image
    $sql = "UPDATE property
            SET title=?, type=?, price=?, location=?, area=?, beds=?, baths=?, garage=?, description=?, updated_at=CURRENT_TIMESTAMP
            WHERE id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        exit('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param(
        'ssissiiisi',
        $title,    
        $type,     
        $price,     
        $location, 
        $area,     
        $beds,   
        $baths,    
        $garage,   
        $description, 
        $id           
    );
}

if (!$stmt->execute()) {
    http_response_code(500);
    exit('Execute failed: ' . $stmt->error);
}

$stmt->close();
$conn->close();

// Back to home with toast flag
header('Location: /alquiloapp/dashboard.php?updated=1');
exit;
