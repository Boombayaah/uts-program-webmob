<?php
// Mendapatkan nama file saat ini
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin-page.css">

</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="col-md-3 col-lg-2 sidebar p-0">
        <div class="p-4">
            <h3 class="sidebar-title mb-4">
                <i class="fas fa-train text-primary me-2"></i>
                <span>CommuterLink</span>
            </h3>

            <ul class="nav flex-column" id="sidebar-nav">
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if ($currentPage == 'dashboard.php') echo 'active'; ?>" href="dashboard.php">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?php if ($currentPage == 'upload_barang.php') echo 'active'; ?>" href="upload_barang.php">
                        <i class="fas fa-upload me-2"></i> Upload Barang
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?php if ($currentPage == 'laporan_hilang.php') echo 'active'; ?>" href="laporan_hilang.php">
                        <i class="fas fa-box-open me-2"></i> Barang Hilang
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?php if ($currentPage == 'laporan_temuan.php') echo 'active'; ?>" href="laporan_temuan.php">
                        <i class="fas fa-search me-2"></i> Barang Temuan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?php if ($currentPage == 'matching.php') echo 'active'; ?>" href="matching.php">
                        <i class="fas fa-handshake me-2"></i> Matching
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?php if ($currentPage == 'pengembalian_barang.php') echo 'active'; ?>" href="pengembalian_barang.php">
                        <i class="fa-regular fa-calendar-check me-2"></i> Jadwal Pengembalian
                    </a>
                </li>

                <?php if ($logged_in): ?>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="../user/profile.php">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link" href="../auth/logout.php">
                            <i class="fas fa-sign-out me-2"></i> Logout
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>