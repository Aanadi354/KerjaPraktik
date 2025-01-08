    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <!-- Tambahkan Tailwind dan GSAP CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link href="style.css">
        <link rel="stylesheet" href="style-news.css">

        <style>
            .scroll-container {
                display: flex;
                overflow-x: auto;
                scroll-behavior: smooth;
                gap: 1.5rem;
                padding: 2rem;
                scroll-snap-type: x mandatory;
            }

            .scroll-container::-webkit-scrollbar {
                display: none;
            }

            .scroll-box {
                scroll-snap-align: center;
                flex-shrink: 0;
                width: 100%;
                max-width: 800px;
                background: white;
                border-radius: 2px;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .scroll-box:hover {
                transform: scale(1.05);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            }

            .scroll-box img {
                width: 100%;
                height: 450px;
                object-fit: cover;
            }

            .scroll-box .content {
                padding: 1.5rem;
            }

            .scroll-box .description {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                line-height: 1.6;
                color: #495057;
            }

            .scroll-box .full-description {
                display: none;
                line-height: 1.6;
                color: #495057;
            }

            .scroll-box .meta {
                margin-top: 10px;
                font-size: 14px;
                color: #868e96;
            }

            .scroll-box button {
                margin-top: 15px;
                background: none;
                color: #007bff;
                border: none;
                cursor: pointer;
                font-size: 14px;
                text-decoration: underline;
            }

            /* Style untuk tulisan "Terkini" agar sejajar dan tebal */
    h2.section-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: -5px; /* Sesuaikan jarak dengan garis */
        position: relative;
    }


            /* Media query untuk tampilan mobile */
            @media (max-width: 768px) {
                .scroll-container {
                    flex-direction: column;
                    overflow-x: hidden;
                    overflow-y: auto;
                    scroll-snap-type: y mandatory;
                }

                .scroll-box {
                    scroll-snap-align: start;
                    width: 100%;
                    max-width: none;
                }

                .scroll-buttons {
                    display: none;
                }
            }

            .garis-container {
            position: relative;
            height: 5px;
            background-color: rgba(128, 128, 128, 0.3); /* Warna abu-abu transparan */
            margin: 0 160px; /* Jarak kiri dan kanan */
            }

            .garis-merah {
                position: absolute;
                top: 0;
                left: 0;
                width: 15%; /* Panjang bagian merah */
                height: 100%;
                background-color: red; /* Warna merah */
            }


            
        
        </style>
    </head>
    <body class="flex flex-col min-h-screen bg-gradient-to-b from-blue-100 via-white to-gray-100 text-gray-800 font-poppins">
        <!-- Navbar -->
        <?php include 'layouts/navbar.php'; ?>

        <!-- Hero Section with Video Background -->
        <section class="relative -mt-24 h-screen">
            <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover">
                <source src="images/home.mp4" type="video/mp4">
                Browser Anda tidak mendukung tag video.
            </video>
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                <div class="text-center text-white px-4">
                    <h1 class="text-5xl font-bold mb-6">Selamat Datang di Website Kami</h1>
                    <p class="text-lg mb-8">Temukan inspirasi dan informasi terbaik di sini</p>
                    <a href="#" class="bg-blue-600 hover:bg-blue-800 text-white py-3 px-6 rounded-lg shadow-lg transition duration-300">Jelajahi</a>
                </div>
            </div>
        </section>

        <section class="my-16 container mx-auto px-6 flex flex-col items-center">
            <h2 class="text-4xl font-bold text-center mb-12">Konten Unggulan</h2>
            <div class="relative w-full flex justify-center items-center">
                <div class="scroll-container flex gap-6 w-full max-w-5xl" id="scroll-container">
                    <?php
                    // Sambungkan ke database robomarine
                    $conn = new mysqli('localhost', 'root', '', 'robomarine');
        
                    // Periksa koneksi
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }
        
                    $sql = "SELECT id_konten, gambar, judul, deskripsi, autor, tanggal, link FROM konten";
                    $result = $conn->query($sql);
        
                    if ($result->num_rows > 0) {
                        while ($item = $result->fetch_assoc()) {
                            echo '<div class="scroll-box">';
                            echo '<img src="assets/uploads/' . $item['gambar'] . '" alt="Content Image">';
                            echo '<div class="content">';
                            echo '<h3 class="font-bold text-lg">' . $item['judul'] . '</h3>';
                            echo '<p class="description">' . substr($item['deskripsi'], 0, 100) . '...</p>';
                            echo '<p class="meta">Diposting oleh ' . $item['autor'] . ' pada ' . $item['tanggal'] . '</p>';
                            echo '<a href="konten_detail.php?id=' . $item['id_konten'] . '" class="text-blue-500 underline">Selengkapnya</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="text-center">Tidak ada konten tersedia.</p>';
                    }
        
                    $conn->close();
                    ?>
                </div>
            </div>
        
            <!-- Scroll Buttons -->
            <div class="scroll-buttons flex gap-4 mt-8">
                <button id="prev" class="px-6 py-3 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition duration-300">&#8592; Sebelumnya</button>
                <button id="next" class="px-6 py-3 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition duration-300">Berikutnya &#8594;</button>
            </div>
        </section>


    <!-- ============================================ -->
    <div class="judul">
        <h2 class="section-title">Berita Populer</h2>

        <div class="garis-container">
            <div class="garis-merah"></div>
        </div>
    </div>
    <section class="news-section container mx-auto px-6 my-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            $conn = new mysqli('localhost', 'root', '', 'robomarine');
    
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }
    
            $sql = "SELECT id_konten, gambar, deskripsi, autor, tanggal, link FROM konten";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                while ($item = $result->fetch_assoc()) {
                    echo '<div class="news-box">';
                    echo '<img src="assets/uploads/' . $item['gambar'] . '" alt="News Image">';
                    echo '<div class="news-content">';
                    echo '<h3 class="news-title">' . substr($item['deskripsi'], 0, 50) . '...</h3>';
                    echo '<p class="news-meta">Diposting oleh ' . $item['autor'] . ' pada ' . $item['tanggal'] . '</p>';
                    echo '<a href="konten_detail.php?id=' . $item['id_konten'] . '" class="text-blue-500 underline">Selengkapnya</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Tidak ada berita terkini.</p>';
            }
            $conn->close();
            ?>
        </div>
    </section>
    
    

    <a href="admin/dashbordadmin.php" style="padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">Go to Dashboard</a>


    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>
    <!-- ======================================================== -->
    <script src="assets/js/index.js"></script>
    </body>
    </html>
