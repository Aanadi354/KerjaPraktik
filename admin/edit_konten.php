<?php
include '../config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM konten WHERE id_konten = $id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deskripsi = $_POST['deskripsi'];
    $link = $_POST['link'];
    $autor = $_POST['autor'];
    $tanggal = $_POST['tanggal'];
    $gambar_lama = $data['gambar'];
    $gambar = $_FILES['gambar']['name'];

    // Jika gambar baru diupload, ganti gambar
    if ($gambar) {
        $upload_dir = 'assets/uploads/';
        $upload_file = $upload_dir . basename($gambar);

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_file)) {
            // Hapus gambar lama
            if (file_exists($upload_dir . $gambar_lama)) {
                unlink($upload_dir . $gambar_lama);
            }
        } else {
            die("Gagal mengupload gambar baru.");
        }
    } else {
        $gambar = $gambar_lama; // Tetap gunakan gambar lama
    }

    // Update data
    $sql = "UPDATE konten SET gambar = '$gambar', deskripsi = '$deskripsi', link = '$link', tanggal = '$tanggal', autor = $autor WHERE id_konten = $id";
    if ($conn->query($sql)) {
        header('Location: dashbordadmin.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..assets/css/styles.css">
    <title>Edit Konten</title>
</head>
<body>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <h2>Edit Konten</h2>
            <label for="gambar">Upload Gambar Baru (Opsional):</label>
            <input type="file" name="gambar">
            <p>Gambar Saat Ini:</p>
            <img src="../assets/uploads/<?= $data['gambar'] ?>" alt="Gambar" width="100">

            <label for="deskripsi">Deskripsi:</label>
            <textarea name="deskripsi" required><?= $data['deskripsi'] ?></textarea>

            <label for="link">Link:</label>
            <input type="url" name="link" value="<?= $data['link'] ?>">

            <label for="autor">Autor:</label>
            <input type="number" name="autor" value="<?= $data['autor'] ?>" required>

            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
