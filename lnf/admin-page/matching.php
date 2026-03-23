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

$category = "";
$file_name = "";

if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
    $file_name = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    move_uploaded_file($tmp_name, "../assets/images/uploads/" . $file_name);
}

if (isset($_POST['btnMatch'])) {

    $idFound = $_POST['found_item_id'];
    $idLost = $_POST['lost_report_id'];
    $matchedBy = $_SESSION['user_id'];

    // update found item
    $sql1 = "UPDATE found_items
            SET status = 'Menunggu Verifikasi Atasan'
            WHERE found_item_id = '$idFound'";
    mysqli_query($conn, $sql1);

    // insert matching dengan status Pending
    $sql2 = "INSERT INTO matchings
            (found_item_id, lost_report_id, matched_by, approval_status)
            VALUES
            ('$idFound','$idLost','$matchedBy','Pending')";
    mysqli_query($conn, $sql2);

    // tahan proses 5 detik
    sleep(5);

    // update status jadi diajukan
    $sql3 = "UPDATE matchings
            SET approval_status = 'Diajukan ke Atasan'
            WHERE found_item_id = '$idFound'
            AND lost_report_id = '$idLost'";
    mysqli_query($conn, $sql3);

    header("location:matching.php");
    exit;
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

$sql_category = "SELECT * 
                FROM item_category
                ORDER BY category";
$hasil_category = mysqli_query($conn, $sql_category);

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

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin-page.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }
    </style>

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
                <?php if ($category == "") { ?>
                    <div class="component-card" style="max-width:500px;">
                        <form action="matching.php" method="GET">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pilih Kategori Barang</label>
                                <select class="form-select" name="category" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($hasil_category as $single_category) {
                                        echo "<option value=$single_category[category]>$single_category[category]</option>";
                                    }
                                    ; ?>
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
                                                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>"
                                                    data-id="<?php echo $id; ?>">
                                                    <section class="component-card">
                                                        <div class="wireframe-box">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="border rounded p-3 text-center mb-3">
                                                                        <img src="assets/images/uploads/<?php echo $bukti; ?>" alt="Barang hilang"
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

                                                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>"
                                                    data-id="<?php echo $id; ?>">
                                                    <section class="component-card">
                                                        <div class="wireframe-box">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="border rounded p-3 text-center mb-3">
                                                                        <img src="assets/images/uploads/<?php echo $bukti; ?>" alt="Barang temuan"
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
                                                                            <p class="fw-bold"><?php echo $full_name; ?></p>
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