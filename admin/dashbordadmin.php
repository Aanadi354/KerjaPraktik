<?php
include '../config.php';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get data
$sql = "SELECT * FROM konten ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$total_data = $conn->query("SELECT COUNT(*) as total FROM konten")->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-user-shield"></i> Dashboard</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboardadmin.php" class="active"><i class="fas fa-home"></i> Kelola Konten</a></li>
                <li><a href="../admin/create_konten.php"><i class="fas fa-plus"></i> Tambah Konten</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
            </header>

            <!-- Content -->
            <div class="content">
                <h2>Daftar Konten</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Link</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= $row['id_konten'] ?></td>
                                    <td><img src="../assets/uploads/<?= $row['gambar'] ?>" alt="Gambar"></td>
                                    <td><?= substr($row['deskripsi'], 0, 50) ?>...</td>
                                    <td><a href="<?= $row['link'] ?>" target="_blank">Link</a></td>
                                    <td><?= $row['tanggal'] ?></td>
                                    <td>
                                        <a href="../admin/edit_konten.php?id=<?= $row['id_konten'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                        <button class="btn btn-danger" onclick="confirmDelete(<?= $row['id_konten'] ?>)"><i class="fas fa-trash"></i> Hapus</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <p>&copy; <?= date('Y') ?> Admin Dashboard. All rights reserved.</p>
            </footer>
        </div>
    </div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete action
                fetch(`../admin/delete_konten.php?id=${id}`)
                    .then(response => {
                        if (response.ok) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your file has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to delete the content.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            }
        });
    }
</script>
</body>
</html>
