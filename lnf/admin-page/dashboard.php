<?php
session_start();
include "../config/connection.php";
$logged_in = isset($_SESSION['user_id']);

if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 1) {
    header("Location: ../admin_leader-page/dashboardleader.php");
    exit();
} else if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 3) {
    header("Location: ../home.php");
    exit();
}

$sql1 = "select count(*) as total from found_items";
$hasil_found = mysqli_query($conn, $sql1);
$data_found = mysqli_fetch_assoc($hasil_found);
$total_found = $data_found['total'];

$sql2 = "select count(*) as total from lost_reports";
$hasil_lost = mysqli_query($conn, $sql2);
$data_lost = mysqli_fetch_assoc($hasil_lost);
$total_lost = $data_lost['total'];

$sql3 = "select count(*) as total from lost_reports where status = 'Selesai'";
$hasil_selesai = mysqli_query($conn, $sql3);
$data_selesai = mysqli_fetch_assoc($hasil_selesai);
$total_selesai = $data_selesai['total'];

$sql4 = "select count(*) as total from lost_reports where status = 'Sedang Diproses'";
$hasil_proses = mysqli_query($conn, $sql4);
$data_proses = mysqli_fetch_assoc($hasil_proses);
$total_proses = $data_proses['total'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h3 class="sidebar-title mb-4">
                        <i class="fas fa-train text-primary me-2"></i>
                        <span>CommuterLink</span>
                    </h3>

                    <ul class="nav flex-column" id="sidebar-nav">
                        <li class="nav-item mb-2">
                            <a class="nav-link active" href="dashboard.php">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link" href="upload_barang.php">
                                <i class="fas fa-upload me-2"></i> Upload Barang
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link" href="laporan_hilang.php">
                                <i class="fas fa-box-open me-2"></i> Barang Hilang
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link" href="laporan_hilang.php">
                                <i class="fas fa-search me-2"></i> Barang Temuan
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link" href="matching.php">
                                <i class="fas fa-handshake me-2"></i> Matching
                            </a>
                        </li>

                        <?php if ($logged_in): ?>
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="user/profile.php">
                                    <i class="fas fa-user me-2"></i> Profile
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a class="nav-link" href="auth/logout.php">
                                    <i class="fas fa-sign-out me-2"></i> Logout
                                </a>
                            </li>

                        <?php endif; ?>


                    </ul>

                </div>
            </div>

            <div class="col-md-9 col-lg-10 main-content">
                <h4 class="mt-4">Dashboard Admin</h4>
                <div class="wireframe-box">
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="dashboard-card" style="background-color: #EFF6FF;">
                                <h5><i class="fas fa-box me-2"></i>Barang Temuan</h5>
                                <h2 class="fw-bold"><?php echo $total_found; ?></h2>
                                <p class="text-muted mb-0">Hari ini</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="dashboard-card" style="background-color: #FEF3C7;">
                                <h5><i class="fas fa-search me-2"></i>Laporan Hilang</h5>
                                <h2 class="fw-bold"><?php echo $total_lost; ?></h2>
                                <p class="text-muted mb-0">Hari ini</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="dashboard-card" style="background-color: #D1FAE5;">
                                <h5 class="text-nowrap"><i class="fas fa-handshake me-2"></i>Dikembalikan</h5>
                                <h2 class="fw-bold"><?php echo $total_selesai; ?></h2>
                                <p class="text-muted mb-0">Hari ini</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="dashboard-card" style="background-color: #FEE2E2;">
                                <h5><i class="fas fa-clock me-2"></i>Dalam Proses</h5>
                                <h2 class="fw-bold"><?php echo $total_proses; ?></h2>
                                <p class="text-muted mb-0">Total</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Aktivitas Terbaru</h5>
                        <div id="activity-list">
                            <!-- Activity items will be rendered here -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>