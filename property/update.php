<?php
session_start();
require_once __DIR__ . '/../db_connect.php';

// --- Read POST ---
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$title = $_POST['title'] ?? '';
$type = $_POST['type'] ?? '';
$price = (int) ($_POST['price'] ?? 0);
$location = $_POST['location'] ?? '';
$area = (int) ($_POST['area'] ?? 0);
$beds = (int) ($_POST['beds'] ?? 0);
$baths = (int) ($_POST['baths'] ?? 0);
$garage = isset($_POST['garage']) ? 1 : 0;
$description = $_POST['description'] ?? '';
$imageOld = $_POST['image_old'] ?? ''; // relative path from DB
$imagePath = ''; // new uploaded path (if any)

if ($id <= 0) {
    http_response_code(400);
    exit('Invalid id');
}

// --- Image replacement ---
if (!empty($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
    $uploadsDir = __DIR__ . '/../uploads';

    // Ensure uploads directory exists, create if not
    if (!is_dir($uploadsDir)) {
        // 0775 permissions make directory writable by group
        @mkdir($uploadsDir, 0775, true);
    }

    // basename returns filename with extension
    // e.g., from '/path/to/my photo.jpg' returns 'my photo.jpg'
    $basename = basename($_FILES['image']['name']);
    $safeName = preg_replace('/\s+/', '_', $basename);
    $target = $uploadsDir . '/' . time() . '_' . $safeName;

    // Move upload
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Store relative path
        $imagePath = 'uploads/' . basename($target);

        // Remove old file if it existed and is inside project
        if (!empty($imageOld)) {
            $base = realpath(__DIR__ . '/..'); // project root
            $oldAbs = realpath($base . '/' . $imageOld);

            @unlink($oldAbs);
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
