<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $link = $_POST['link'];
    $autor = $_POST['autor'];
    $tanggal = $_POST['tanggal'];
    $kategori = $_POST['kategori'];
    $gambar = $_FILES['gambar']['name'];

    if ($gambar) {
        $upload_dir = '../assets/uploads/';
        $upload_file = $upload_dir . basename($gambar);

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_file)) {
            $sql = "INSERT INTO konten (judul, gambar, deskripsi, link, tanggal, autor, kategori) VALUES ('$judul', '$gambar', '$deskripsi', '$link', '$tanggal', $autor, '$kategori')";
            if ($conn->query($sql)) {
                echo "<script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Konten berhasil ditambahkan.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '../admin/dashbordadmin.php';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: '" . $conn->error . "',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal mengunggah gambar.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Tambah Konten</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input,
        .form-container textarea,
        .form-container select,
        .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container button {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <h2>Tambah Konten</h2>

            <label for="judul">Judul:</label>
            <input type="text" name="judul" required>

            <label for="gambar">Upload Gambar:</label>
            <input type="file" name="gambar" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea name="deskripsi" required></textarea>

            <label for="link">Link:</label>
            <input type="url" name="link">

            <label for="autor">Autor:</label>
            <input type="number" name="autor" required>

            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" required>

            <label for="kategori">Kategori:</label>
            <input type="text" name="kategori">

            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
