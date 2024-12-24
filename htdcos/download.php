<?php
session_start();
require_once('db.php');

$file_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM files WHERE id = $file_id";
$result = mysqli_query($conn, $query);
$file = mysqli_fetch_assoc($result);

if ($file && (isset($_SESSION['admin']) || $file['is_public'])) {
    $filepath = $file['file_path'];
    if (file_exists($filepath)) {
        header('Content-Type: ' . $file['mime_type']);
        header('Content-Disposition: attachment; filename="' . $file['original_name'] . '"');
        header('Content-Length: ' . $file['file_size']);
        readfile($filepath);
        exit();
    }
}

header('Location: admin.php'); 