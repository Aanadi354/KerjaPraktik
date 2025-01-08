<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "robomarine");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_konten = intval($_POST['id_konten']);
    $nama_pengunjung = $conn->real_escape_string($_POST['nama_pengunjung']);
    $email_pengunjung = $conn->real_escape_string($_POST['email_pengunjung']);
    $komentar = $conn->real_escape_string($_POST['komentar']);

    // Query untuk menyimpan komentar
    $query = "INSERT INTO komentar_postingan (id_konten, nama_pengunjung, email_pengunjung, komentar, tanggal_komentar)
            VALUES ($id_konten, '$nama_pengunjung', '$email_pengunjung', '$komentar', NOW())";

    if ($conn->query($query)) {
        // Redirect kembali ke halaman detail dengan ID
        header("Location: /robomarine/konten_detail.php?id=$id_konten");
        exit;
    } else {
        echo "Gagal mengirim komentar: " . $conn->error;
    }
}

$conn->close();
?>
