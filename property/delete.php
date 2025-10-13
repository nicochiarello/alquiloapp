<?php
session_start();
require_once __DIR__ . '/../db_connect.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
  http_response_code(400);
  exit('Invalid id');
}

// 1) Get current image (to remove file later)
$imgPath = '';
$sqlSel = "SELECT image FROM property WHERE id = ?";
if ($stmtSel = $conn->prepare($sqlSel)) {
  $stmtSel->bind_param('i', $id);
  $stmtSel->execute();
  $stmtSel->bind_result($imgPath);
  $stmtSel->fetch();
  $stmtSel->close();
}

// 2) Delete row
$sqlDel = "DELETE FROM property WHERE id = ?";
$stmtDel = $conn->prepare($sqlDel);
if (!$stmtDel) {
  http_response_code(500);
  exit('Prepare failed: ' . $conn->error);
}
$stmtDel->bind_param('i', $id);

if (!$stmtDel->execute()) {
  http_response_code(500);
  exit('Execute failed: ' . $stmtDel->error);
}
$stmtDel->close();

// 3) Remove image file if local
if (!empty($imgPath)) {
  $base = realpath(__DIR__ . '/..');           // project root containing /uploads
  $abs  = realpath($base . '/' . $imgPath);    // absolute path to file
  if ($abs && strpos($abs, $base) === 0 && is_file($abs)) {
    @unlink($abs);
  }
}

$conn->close();

// 4) Back to home
header('Location: /alquiloapp/dashboard.php?created=1');
exit;
