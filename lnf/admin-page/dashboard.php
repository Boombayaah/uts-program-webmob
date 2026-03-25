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
    <title>Commuter | Dashbor Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin-page.css"> 

    <!--Favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="../assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "admin_sidebar.php"; ?>
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