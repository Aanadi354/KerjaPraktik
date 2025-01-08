<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konten</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .content-header {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .comment-section {
            margin-top: 40px;
        }
        .comment {
            margin-bottom: 20px;
        }
        .bubble {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 10px;
            position: relative;
        }
        .bubble::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20px;
            width: 0;
            height: 0;
            border: 10px solid transparent;
            border-top-color: #e9ecef;
            border-bottom: 0;
            margin-left: -10px;
            margin-bottom: -10px;
        }
        .admin-bubble {
            background-color: #d1ecf1;
            margin-left: 50px;
        }
        .admin-bubble::after {
            border-top-color: #d1ecf1;
        }
        .content-header img {
        width: 100%;
        height: 300px; /* Tentukan tinggi sesuai kebutuhan */
        object-fit: cover; /* Memastikan gambar tetap proporsional */
        }
    </style>
</head>
<body>
    <?php include 'layouts/navbar.php'; ?>
    <div class="container">
        <?php
        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "robomarine"); // Ganti "nama_database" dengan nama database Anda

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        if (isset($_GET['id'])) {
            $id_konten = intval($_GET['id']);
        }

        // Query untuk detail konten
        $result = $conn->query("SELECT * FROM konten WHERE id_konten = $id_konten");

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
        ?>
            <div class="content-header">
                <h1 class="mb-3"><?= $row['judul'] ?></h1>
                <p><em><?= date("d M Y", strtotime($row['tanggal'])) ?> | Oleh <?= $row['autor'] ?></em></p>
                <img src="assets/uploads/<?= $row['gambar'] ?>" alt="<?= $row['judul'] ?>" class="img-fluid mb-4">
                <p><?= nl2br($row['deskripsi']) ?></p>
                <?php if ($row['link']) { ?>
                    <a href="<?= $row['link'] ?>" target="_blank">Referensi Konten</a>
                <?php } ?>
            </div>
        <?php
        } else {
            echo "<p>Konten tidak ditemukan.</p>";
        }
        ?>

        <div class="comment-section">
            <h3>Komentar</h3>
            <div class="comments">
                <?php
                // Query untuk komentar
                $comments = $conn->query("SELECT * FROM komentar_postingan WHERE id_konten = $id_konten ORDER BY tanggal_komentar ASC");

                if ($comments && $comments->num_rows > 0) {
                    while ($comment = $comments->fetch_assoc()) {
                        echo "<div class='comment'>";
                        echo "<div class='bubble'><strong>{$comment['nama_pengunjung']}</strong> ({$comment['email_pengunjung']})<br>{$comment['komentar']}<br><small><em>{$comment['tanggal_komentar']}</em></small></div>";
                        if ($comment['balasan']) {
                            echo "<div class='bubble admin-bubble'><strong>Admin</strong><br>{$comment['balasan']}<br><small><em>{$comment['tanggal_balasan']}</em></small></div>";
                        }
                        echo "</div>";
                    }
                } else {
                    echo "<p>Belum ada komentar.</p>";
                }
                ?>
            </div>

            <!-- Form Komentar -->
            <form method="post" action="submit_comment.php" class="mt-4">
            <input type="hidden" name="id_konten" value="<?= $id_konten ?>">
                <div class="mb-3">
                    <label for="nama_pengunjung" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama_pengunjung" name="nama_pengunjung" required>
                </div>
                <div class="mb-3">
                    <label for="email_pengunjung" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email_pengunjung" name="email_pengunjung">
                </div>
                <div class="mb-3">
                    <label for="komentar" class="form-label">Komentar</label>
                    <textarea class="form-control" id="komentar" name="komentar" rows="3" required></textarea>
                </div>
                <input type="hidden" name="id_konten" value="<?= $id_konten ?>">
                <button type="submit" class="btn btn-primary">Kirim Komentar</button>
            </form>
        </div>
    </div>
    <?php include 'layouts/footer.php'; ?>
</body>
</html>
