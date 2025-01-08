<?php
include '../config.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = $_GET['id'];

// Ambil informasi gambar
$sql = "SELECT gambar FROM konten WHERE id_konten = $id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan.");
}

// Hapus gambar dari folder
$upload_dir = '../assets/uploads/';
if (file_exists($upload_dir . $data['gambar'])) {
    unlink($upload_dir . $data['gambar']);
}

// Hapus data dari database
$sql = "DELETE FROM konten WHERE id_konten = $id";
if ($conn->query($sql)) {
    header('Location: ../admin/dashbordadmin.php');
} else {
    echo "Error: " . $conn->error;
}
?>
