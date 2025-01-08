<?php
// Koneksi ke database
$host = "localhost";
$user = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda
$database = "robomarine";
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan data konten
$sql = "SELECT * FROM konten ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Tambahkan Tailwind dan GSAP CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link href="style.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olahraga</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px;
        }
        .header {
            font-size: 20px;
            font-weight: normal;
            color: #000;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        .header::after {
            content: "";
            width: 50px;
            height: 3px;
            background-color: red;
            position: absolute;
            bottom: -5px;
            left: 0;
        }
        .header .link-index {
            font-size: 14px;
            color: #555;
            display: flex;
            align-items: center;
        }
        .header .link-index:hover {
            color: #000;
            text-decoration: none;
        }
        .header .link-index::after {
            content: ">";
            font-weight: bold;
            margin-left: 5px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 15px;
        }
        .card-title {
            font-size: 16px;
            font-weight: normal;
            margin: 0 0 10px;
            color: #333;
        }
        .card-meta {
            font-size: 12px;
            color: #777;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'layouts/navbar.php'; ?>
    <div class="container">
        <div class="header">
            Pilihan Editor
            <a href="#" class="link-index">Indeks</a>
        </div>
        <div class="grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="assets/uploads/' . $row['gambar'] . '" alt="Gambar">';
                    echo '<div class="card-content">';
                    echo '<div class="card-title">' . $row['deskripsi'] . '</div>';
                    echo '<div class="card-meta"><span>' . date("d M Y", strtotime($row['tanggal'])) . '</span></div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Tidak ada konten tersedia.</p>';
            }
            ?>
        </div>
    </div>
    <?php include 'layouts/footer.php'; ?>
</body>
</html>
<?php
$conn->close();
?>
