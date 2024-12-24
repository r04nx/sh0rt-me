<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit();
}

$upload_dir = 'uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_FILES['files']) {
    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['files']['name'][$key];
        $file_size = $_FILES['files']['size'][$key];
        $file_tmp = $_FILES['files']['tmp_name'][$key];
        $file_type = $_FILES['files']['type'][$key];
        
        // Generate unique filename
        $stored_name = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", $file_name);
        $file_path = $upload_dir . $stored_name;
        
        if (move_uploaded_file($file_tmp, $file_path)) {
            $is_public = isset($_POST['is_public']) ? 1 : 0;
            
            $stmt = $conn->prepare("INSERT INTO files (filename, original_name, mime_type, file_size, file_path, is_public) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $stored_name, $file_name, $file_type, $file_size, $file_path, $is_public);
            $stmt->execute();
        }
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']); 