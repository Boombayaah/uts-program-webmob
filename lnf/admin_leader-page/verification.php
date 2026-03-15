<?php
session_start();
include "../config/connection.php";
$logged_in = isset($_SESSION['user_id']);

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 2) {
        header("Location: ../admin-page/dashboard.php");
    } else {
        header("Location: ../home.php");
    }
    exit();
}

$category = "";

if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

$sql = "SELECT *
        FROM matchings m
        JOIN found_items f on f.found_item_id = m.found_item_id 
        JOIN lost_reports l on l.lost_report_id = m.lost_report_id
        WHERE f.category = '$category'
        AND f.status = 'Menunggu Verifikasi Atasan'
        AND m.approval_status = 'Diajukan ke Atasan'
        ORDER BY m.created_at";
$hasil_matching = mysqli_query($conn, $sql);

$sql_category = "SELECT * 
                FROM item_category
                ORDER BY category";
$hasil_category = mysqli_query($conn, $sql_category);

// $disableBtn = (mysqli_num_rows($hasil_found) == 0 || mysqli_num_rows($hasil_lost) == 0) ? "disabled" : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Verification</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin-page.css"> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "leader_sidebar.php"; ?>
            <div class="col-md-9 col-lg-10 main-content">
                <?php if ($category == "") { ?>
                    <div class="component-card" style="max-width:500px;">
                        <form action="verification.php" method="GET">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pilih Kategori Barang</label>
                                <select class="form-select" name="category" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($hasil_category as $single_category) {
                                        echo "<option value=$single_category[category]>$single_category[category]</option>";
                                    }; ?>
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
                                if (mysqli_num_rows($hasil_matching) == 0) {
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
        document.getElementById("matchForm").addEventListener("submit", function() {

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