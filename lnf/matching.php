<?php
session_start();
$logged_in = isset($_SESSION['user_id']);
include "config/connection.php";
$category = "";
$file_name = "";


if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
    $file_name = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    move_uploaded_file($tmp_name, "uploads/" . $file_name);
}

if (isset($_POST['btnMatch'])) {

    $idFound = $_POST['found_item_id'];
    $idLost = $_POST['lost_report_id'];

    $sql = "UPDATE found_items
            set status = 'Menunggu Verifikasi Atasan',
            matched_lost_id = '$idLost'
            where found_item_id = '$idFound'";

    if (mysqli_query($conn, $sql)) {
        header("location:matching.php");
        exit;
    }

}

if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

$sql = "SELECT found_items.*, users.full_name, users.phone
        FROM found_items
        JOIN users ON found_items.reported_by = users.user_id
        WHERE category = '$category'
        AND status = 'Diproses'
        ORDER BY found_date";
$hasil_found = mysqli_query($conn, $sql);

$sql_2 = "SELECT lost_reports.*, users.full_name, users.phone
          FROM lost_reports
          JOIN users ON lost_reports.reported_by = users.user_id
          WHERE category = '$category' 
          AND status = 'Sedang Diproses'
          ORDER BY lost_date";
$hasil_lost = mysqli_query($conn, $sql_2);

$disableBtn = (mysqli_num_rows($hasil_found) == 0 || mysqli_num_rows($hasil_lost) == 0) ? "disabled" : "";

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #1E3A8A;
            --secondary-color: #3B82F6;
            --accent-color: #F59E0B;
            --light-bg: #F8FAFC;
            --dark-text: #1F2937;
            --gray-text: #6B7280;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #3B82F6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            background-color: var(--light-bg);
            line-height: 1.6;
        }

        .color-swatch {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            display: inline-block;
            margin-right: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .component-card {
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 30px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .component-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .wireframe-box {
            border: 2px dashed #D1D5DB;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #F9FAFB;
            min-height: 200px;
        }

        .nav-flow {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }

        .nav-step {
            background-color: var(--secondary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            position: relative;
        }

        .nav-step:after {
            content: "→";
            position: absolute;
            right: -15px;
            color: var(--gray-text);
        }

        .nav-step:last-child:after {
            content: "";
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600;
            color: var(--primary-color);
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #1E40AF;
            border-color: #1E40AF;
        }

        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }

        .btn-accent:hover {
            background-color: #D97706;
            border-color: #D97706;
        }

        .sidebar {
            background-color: white;
            border-right: 1px solid #E5E7EB;
            min-height: 100vh;
        }

        /* .sidebar .nav-link.active {
            background-color: #3B82F6;
            color: white;
            border-radius: 8px;
        } */

        .main-content {
            padding: 30px;
        }

        .dashboard-card {
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table-custom {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table-custom thead {
            background-color: var(--primary-color);
            color: white;
        }

        .search-filter {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .sidebar .nav-link {
            color: black;
        }

        .sidebar .nav-link:hover {
            color: #2563eb;
        }

        .sidebar .nav-link.active {
            color: #2563eb;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }
    </style>
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h3 class="mb-4">
                        <i class="fas fa-train text-primary me-2"></i>
                        CommuterLink
                    </h3>

                    <ul class="nav flex-column" id="sidebar-nav">
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="dashboard.php">
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
                            <a class="nav-link" href="laporan_temuan.php">
                                <i class="fas fa-search me-2"></i> Barang Temuan
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link active" href="matching.php">
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
                <?php if ($category == "") { ?>
                    <div class="component-card" style="max-width:500px;">

                        <form action="matching.php" method="GET">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pilih Kategori Barang</label>

                                <select class="form-select" name="category" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="elektronik">Elektronik</option>
                                    <option value="dompet-tas">Dompet & Tas</option>
                                    <option value="dokumen">Dokumen</option>
                                    <option value="aksesoris">Aksesoris</option>
                                    <option value="kunci">Kunci</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <button class="btn btn-primary">
                                <i class="fas fa-search"></i> Lihat Data
                            </button>

                        </form>

                    </div>

                </div>

            <?php } ?>

            <?php if ($category != "") { ?>
                <section class="py-3 bg-light">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                if ($category != "") { // pastikan kategori sudah dipilih
                                    if (mysqli_num_rows($hasil_found) == 0 || mysqli_num_rows($hasil_lost) == 0) {
                                        echo "<div class='alert alert-warning text-center'>
                Tidak cukup data untuk melakukan matching
              </div>";
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-lg-6">
                                <h2 class="mb-4 text-center"><i class="fas fa-info-circle me-2"></i>Detail Barang Hilang
                                </h2>
                                <div id="lostCarousel" class="carousel slide">
                                    <div class="carousel-inner">
                                        <?php
                                        $i = 0;
                                        if (mysqli_num_rows($hasil_lost) > 0) {
                                            while ($row = mysqli_fetch_assoc($hasil_lost)) {
                                                $id = $row['lost_report_id'];
                                                $tanggal = $row['lost_date'];
                                                $laporan = $row['item_name'];
                                                $kategori = $row['category'];
                                                $keterangan = $row['description'];
                                                $lokasi = $row['location'];
                                                $bukti = $row['file'];
                                                $status = $row['status'];
                                                $full_name = $row['full_name'];
                                                $kontak = $row['phone'];

                                                $badge = "";

                                                if ($status == "Sedang Diproses") {
                                                    $badge = '<span class="status-badge me-2" style="background-color: #FEF3C7; color: #92400E;">
                                                        <i class="fas fa-clock me-1"></i>Sedang Diproses
                                                    </span>';
                                                } elseif ($status == "Telah Ditemukan") {
                                                    $badge = '<span class="status-badge me-2" style="background-color: #DBEAFE; color: #1E40AF;">
                                                        <i class="fas fa-exchange-alt me-1"></i>Telah Ditemukan
                                                    </span>';
                                                } elseif ($status == "Menunggu Pengambilan") {
                                                    $badge = '<span class="status-badge me-2" style="background-color: #D1FAE5; color: #065F46;">
                                                        <i class="fas fa-check-circle me-1"></i>Menunggu Pengambilan
                                                    </span>';
                                                } else {
                                                    $badge = '<span class="status-badge me-2" style="background-color: #FEE2E2; color: #991B1B;">
                                                        <i class="fas fa-times-circle me-1"></i> Ditolak
                                                    </span>';
                                                }
                                                ?>

                                                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>" data-id="<?php echo $id; ?>">
                                                    <section class="component-card">
                                                        <div class="wireframe-box">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="border rounded p-3 text-center mb-3">
                                                                        <img src="uploads/<?php echo $bukti; ?>" alt="Barang hilang"
                                                                            class="img-fluid rounded">
                                                                        <div class="mt-3">
                                                                            <button class="btn btn-outline-primary btn-sm me-2"><i
                                                                                    class="fas fa-expand me-1"></i>Perbesar</button>
                                                                            <button class="btn btn-outline-secondary btn-sm"><i
                                                                                    class="fas fa-download me-1"></i>Download</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <h4><?php echo $laporan; ?></h4>
                                                                    <?php echo $badge; ?>

                                                                    <div class="row mb-3 mt-3">
                                                                        <div class="col-6">
                                                                            <p class="mb-1 text-muted">ID Barang</p>
                                                                            <p class="fw-bold"><?php echo $id; ?></p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p class="mb-1 text-muted">Tanggal Dilaporkan</p>
                                                                            <p class="fw-bold"><?php echo $tanggal; ?></p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p class="mb-1 text-muted">Lokasi</p>
                                                                            <p class="fw-bold"><?php echo $lokasi; ?></p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p class="mb-1 text-muted">Dilaporkan Oleh</p>
                                                                            <p class="fw-bold"><?php echo $full_name; ?></p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <p class="mb-1 text-muted">Deskripsi</p>
                                                                        <p><?php echo $keterangan; ?></p>
                                                                    </div>

                                                                    <div class="mb-4">
                                                                        <p class="mb-1 text-muted">Kontak Pelapor</p>
                                                                        <p><i class="fas fa-phone me-2"></i><?php echo $kontak; ?>
                                                                        </p>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            ?>
                                            <div class="carousel-item active">
                                                <section class="component-card text-center">
                                                    <p class="text-muted">Tidak ada laporan barang hilang di kategori ini.</p>
                                                </section>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>

                                    <button class="carousel-control-prev" type="button" data-bs-target="#lostCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>

                                    <button class="carousel-control-next" type="button" data-bs-target="#lostCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <h2 class="mb-4 text-center"><i class="fas fa-info-circle me-2"></i>Detail Barang Temuan
                                </h2>
                                <div id="foundCarousel" class="carousel slide">
                                    <div class="carousel-inner">
                                        <?php
                                        $i = 0;
                                        if (mysqli_num_rows($hasil_found) > 0) {
                                            while ($row = mysqli_fetch_assoc($hasil_found)) {
                                                $id = $row['found_item_id'];
                                                $tanggal = $row['found_date'];
                                                $laporan = $row['item_name'];
                                                $kategori = $row['category'];
                                                $keterangan = $row['description'];
                                                $lokasi = $row['location'];
                                                $bukti = $row['file'];
                                                $status = $row['status'];
                                                $full_name = $row['full_name'];
                                                $kontak = $row['phone'];

                                                $badge = "";

                                                if ($status == "Diproses") {
                                                    $badge = '<span class="status-badge me-2" style="background-color: #FEF3C7; color: #92400E;">
                                                        <i class="fas fa-clock me-1"></i>Sedang Diproses
                                                    </span>';
                                                } elseif ($status == "Menunggu Verifikasi Atasan") {
                                                    $badge = '<span class="status-badge me-2" style="background-color: #DBEAFE; color: #1E40AF;">
                                                        <i class="fas fa-exchange-alt me-1"></i>Menunggu Verifikasi Atasan
                                                    </span>';
                                                } elseif ($status == "Telah Diverifikasi") {
                                                    $badge = '<span class="status-badge me-2" style="background-color: #D1FAE5; color: #065F46;">
                                                        <i class="fas fa-check-circle me-1"></i>Telah Diverifikasi
                                                    </span>';
                                                } elseif ($status == "Diserahkan") {
                                                    $badge = '<span class="status-badge me-2" style="background-color: #D1FAE5; color: #065F46;">
                                                        <i class="fas fa-check-circle me-1"></i>Diserahkan
                                                    </span>';
                                                } else {
                                                    $badge = '<span class="status-badge me-2" style="background-color: #FEE2E2; color: #991B1B;">
                                                        <i class="fas fa-times-circle me-1"></i>Dibatalkan
                                                    </span>';
                                                }
                                                ?>

                                                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>" data-id="<?php echo $id; ?>">
                                                    <section class="component-card">
                                                        <div class="wireframe-box">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="border rounded p-3 text-center mb-3">
                                                                        <img src="uploads/<?php echo $bukti; ?>" alt="Barang temuan"
                                                                            class="img-fluid rounded">
                                                                        <div class="mt-3">
                                                                            <button class="btn btn-outline-primary btn-sm me-2"><i
                                                                                    class="fas fa-expand me-1"></i>Perbesar</button>
                                                                            <button class="btn btn-outline-secondary btn-sm"><i
                                                                                    class="fas fa-download me-1"></i>Download</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <h4>
                                                                        <?php echo $laporan; ?>
                                                                    </h4>
                                                                    <?php echo $badge; ?>


                                                                    <div class="row mb-3 mt-3">
                                                                        <div class="col-6">
                                                                            <p class="mb-1 text-muted">ID Barang</p>
                                                                            <p class="fw-bold">
                                                                                <?php echo $id; ?>
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p class="mb-1 text-muted">Tanggal Ditemukan</p>
                                                                            <p class="fw-bold">
                                                                                <?php echo $tanggal; ?>
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p class="mb-1 text-muted">Lokasi</p>
                                                                            <p class="fw-bold">
                                                                                <?php echo $lokasi; ?>
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p class="mb-1 text-muted">Ditemukan Oleh</p>
                                                                            <p class="fw-bold"><? echo $full_name; ?></p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <p class="mb-1 text-muted">Deskripsi</p>
                                                                        <p>
                                                                            <?php echo $keterangan; ?>
                                                                        </p>
                                                                    </div>

                                                                    <div class="mb-4">
                                                                        <p class="mb-1 text-muted">Kontak Penemu</p>
                                                                        <p><i class="fas fa-phone me-2"></i><?php echo $kontak; ?>
                                                                        </p>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            ?>
                                            <div class="carousel-item active">
                                                <section class="component-card text-center">
                                                    <p class="text-muted">Tidak ada laporan barang temuan di kategori ini.</p>
                                                </section>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>

                                    <button class="carousel-control-prev" type="button" data-bs-target="#foundCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>

                                    <button class="carousel-control-next" type="button" data-bs-target="#foundCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center">

                                <form method="post" id="matchForm">
                                    <input type="hidden" name="found_item_id" id="found_id">
                                    <input type="hidden" name="lost_report_id" id="lost_id">
                                    <button class="btn btn-outline-success btn-lg" name="btnMatch" <?= $disableBtn ?>><i
                                            class="fas fa-check me-1"></i>Match</button>
                                </form>
                            </div>
                        </div>


                    </div>
                </section>
            <?php } ?>
        </div>
    </div>

    <script>
        document.getElementById("matchForm").addEventListener("submit", function () {

            const activeFound = document.querySelector("#foundCarousel .carousel-item.active");
            const activeLost = document.querySelector("#lostCarousel .carousel-item.active");

            const idFound = activeFound.dataset.id;
            const idLost = activeLost.dataset.id;

            document.getElementById("found_id").value = idFound;
            document.getElementById("lost_id").value = idLost;

        });
    </script>
</body>

</html>