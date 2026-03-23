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

$file_name = "";

if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
    $file_name = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    move_uploaded_file($tmp_name, "../assets/images/uploads/" . $file_name);
}

$category = "";

if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

$sql = "SELECT 
        m.matching_id as m_id,

        f.found_item_id as f_item_id,
        f.item_name as f_item_name,
        f.location as f_location,
        f.description as f_description,
        f.status as f_status,
        f.file as f_file,
        f.found_date as f_date,

        l.lost_report_id as l_report_id,
        l.item_name as l_item_name,
        l.location as l_location,
        l.description as l_description,
        l.status as l_status,
        l.file as l_file,
        l.lost_date as l_date,

        uf.full_name as uf_full_name,
        uf.phone as uf_phone,

        ul.full_name as ul_full_name,
        ul.phone as ul_phone 

        FROM matchings m
        JOIN found_items f on f.found_item_id = m.found_item_id 
        JOIN lost_reports l on l.lost_report_id = m.lost_report_id
        JOIN users uf on f.reported_by = uf.user_id
        JOIN users ul on l.reported_by = ul.user_id

        WHERE f.category = '$category'
        AND f.status = 'Menunggu Verifikasi Atasan'
        AND m.approval_status = 'Diajukan ke Atasan'
        ORDER BY m.created_at";
$hasil_matching = mysqli_query($conn, $sql);

$sql_category = "SELECT * 
                FROM item_category
                ORDER BY category";
$hasil_category = mysqli_query($conn, $sql_category);

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

if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
    $file_name = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    move_uploaded_file($tmp_name, "assets/images/uploads/" . $file_name);
}

$disableBtn = (mysqli_num_rows($hasil_matching) == 0) ? "disabled" : "";

if (isset($_POST['action'], $_POST['matching_id'])) {

    $m_id = $_POST['matching_id'];
    $action = $_POST['action'];

    $q = mysqli_query($conn, "SELECT lost_report_id, found_item_id FROM matchings WHERE matching_id = '$m_id'");
    $data = mysqli_fetch_assoc($q);

    if (!$data) {
        die("error");
    }

    $lost_id = $data['lost_report_id'];
    $found_id = $data['found_item_id'];

    mysqli_begin_transaction($conn);

    try {
        if ($action === 'verify') {

            mysqli_query($conn, "UPDATE lost_reports SET status='Telah ditemukan' WHERE lost_report_id='$lost_id'");
            mysqli_query($conn, "UPDATE found_items SET status='Telah diverifikasi' WHERE found_item_id='$found_id'");
            mysqli_query($conn, "UPDATE matchings SET approval_status='Disetujui' WHERE matching_id='$m_id'");

        } elseif ($action === 'mismatch') {

            mysqli_query($conn, "UPDATE lost_reports SET status='Sedang Diproses' WHERE lost_report_id='$lost_id'");
            mysqli_query($conn, "UPDATE found_items SET status='Dibatalkan' WHERE found_item_id='$found_id'");
            mysqli_query($conn, "UPDATE matchings SET approval_status='Ditolak' WHERE matching_id='$m_id'");
        }

        mysqli_commit($conn);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "error: " . $e->getMessage();
    }
}
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
                                    if (mysqli_num_rows($hasil_matching) == 0) {
                                        echo "<div class='alert alert-warning text-center'>
                Tidak cukup data untuk melakukan matching
              </div>";
                                    }
                                }
                                ?>
                            </div>



                            <div class="col-lg-12">
                                <h2 class="mb-4 text-center"><i class="fas fa-info-circle me-2"></i>Detail Barang Match
                                </h2>
                                <div id="verificationCarousel" class="carousel slide">
                                    <div class="carousel-inner">
                                        <?php
                                        $i = 0;
                                        if (mysqli_num_rows($hasil_matching) > 0) {
                                            while ($row = mysqli_fetch_assoc($hasil_matching)) {
                                                $m_id = $row['m_id'];

                                                $f_id = $row['f_item_id'];
                                                $f_item_name = $row['f_item_name'];
                                                $f_location = $row['f_location'];
                                                $f_description = $row['f_description'];
                                                $f_status = $row['f_status'];
                                                $f_file = $row['f_file'];
                                                $f_date = $row['f_date'];
                                                $uf_full_name = $row['uf_full_name'];
                                                $uf_phone = $row['uf_phone'];

                                                $l_id = $row['l_report_id'];
                                                $l_item_name = $row['l_item_name'];
                                                $l_location = $row['l_location'];
                                                $l_description = $row['l_description'];
                                                $l_status = $row['l_status'];
                                                $l_file = $row['l_file'];
                                                $l_date = $row['l_date'];
                                                $ul_full_name = $row['ul_full_name'];
                                                $ul_phone = $row['ul_phone'];

                                                $f_badge = "";

                                                if ($f_status == "Diproses") {
                                                    $f_badge = '<span class="status-badge me-2" style="background-color: #FEF3C7; color: #92400E;">
                                                        <i class="fas fa-clock me-1"></i>Sedang Diproses
                                                    </span>';
                                                } elseif ($f_status == "Menunggu Verifikasi Atasan") {
                                                    $f_badge = '<span class="status-badge me-2" style="background-color: #DBEAFE; color: #1E40AF;">
                                                        <i class="fas fa-exchange-alt me-1"></i>Menunggu Verifikasi Atasan
                                                    </span>';
                                                } elseif ($f_status == "Telah Diverifikasi") {
                                                    $f_badge = '<span class="status-badge me-2" style="background-color: #D1FAE5; color: #065F46;">
                                                        <i class="fas fa-check-circle me-1"></i>Telah Diverifikasi
                                                    </span>';
                                                } elseif ($f_status == "Diserahkan") {
                                                    $f_badge = '<span class="status-badge me-2" style="background-color: #D1FAE5; color: #065F46;">
                                                        <i class="fas fa-check-circle me-1"></i>Diserahkan
                                                    </span>';
                                                } else {
                                                    $f_badge = '<span class="status-badge me-2" style="background-color: #FEE2E2; color: #991B1B;">
                                                        <i class="fas fa-times-circle me-1"></i>Dibatalkan
                                                    </span>';
                                                }

                                                $l_badge = "";

                                                if ($l_status == "Sedang Diproses") {
                                                    $l_badge = '<span class="status-badge me-2" style="background-color: #FEF3C7; color: #92400E;">
                                                        <i class="fas fa-clock me-1"></i>Sedang Diproses
                                                    </span>';
                                                } elseif ($l_status == "Telah Ditemukan") {
                                                    $l_badge = '<span class="status-badge me-2" style="background-color: #DBEAFE; color: #1E40AF;">
                                                        <i class="fas fa-exchange-alt me-1"></i>Telah Ditemukan
                                                    </span>';
                                                } elseif ($l_status == "Menunggu Pengambilan") {
                                                    $l_badge = '<span class="status-badge me-2" style="background-color: #D1FAE5; color: #065F46;">
                                                        <i class="fas fa-check-circle me-1"></i>Menunggu Pengambilan
                                                    </span>';
                                                } else {
                                                    $l_badge = '<span class="status-badge me-2" style="background-color: #FEE2E2; color: #065F46;">
                                                        <i class="fas fa-times-circle me-1"></i>Selesai
                                                    </span>';
                                                }
                                                ?>

                                                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>"
                                                    data-id="<?php echo $m_id; ?>">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <section class="component-card">
                                                                <div class="wireframe-box">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="border rounded p-3 text-center mb-3">
                                                                                <img src="assets/images/uploads/<?php echo $f_file; ?>"
                                                                                    alt="Barang temuan" class="img-fluid rounded">
                                                                                <div class="mt-3">
                                                                                    <button
                                                                                        class="btn btn-outline-primary btn-sm me-2"><i
                                                                                            class="fas fa-expand me-1"></i>Perbesar</button>
                                                                                    <button
                                                                                        class="btn btn-outline-secondary btn-sm"><i
                                                                                            class="fas fa-download me-1"></i>Download</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                            <h4>
                                                                                <?php echo $f_item_name; ?>
                                                                            </h4>
                                                                            <?php echo $f_badge; ?>


                                                                            <div class="row mb-3 mt-3">
                                                                                <div class="col-6">
                                                                                    <p class="mb-1 text-muted">ID Barang</p>
                                                                                    <p class="fw-bold">
                                                                                        <?php echo $f_id; ?>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <p class="mb-1 text-muted">Tanggal Ditemukan</p>
                                                                                    <p class="fw-bold">
                                                                                        <?php echo $f_date; ?>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <p class="mb-1 text-muted">Lokasi</p>
                                                                                    <p class="fw-bold">
                                                                                        <?php echo $f_location; ?>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <p class="mb-1 text-muted">Ditemukan Oleh</p>
                                                                                    <p class="fw-bold"><?php echo $uf_full_name; ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <p class="mb-1 text-muted">Deskripsi</p>
                                                                                <p>
                                                                                    <?php echo $f_description; ?>
                                                                                </p>
                                                                            </div>

                                                                            <div class="mb-4">
                                                                                <p class="mb-1 text-muted">Kontak Penemu</p>
                                                                                <p><i
                                                                                        class="fas fa-phone me-2"></i><?php echo $uf_phone; ?>
                                                                                </p>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <section class="component-card">
                                                                <div class="wireframe-box">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="border rounded p-3 text-center mb-3">
                                                                                <img src="assets/images/uploads/<?php echo $l_file; ?>"
                                                                                    alt="Barang hilang" class="img-fluid rounded">
                                                                                <div class="mt-3">
                                                                                    <button
                                                                                        class="btn btn-outline-primary btn-sm me-2"><i
                                                                                            class="fas fa-expand me-1"></i>Perbesar</button>
                                                                                    <button
                                                                                        class="btn btn-outline-secondary btn-sm"><i
                                                                                            class="fas fa-download me-1"></i>Download</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                            <h4>
                                                                                <?php echo $l_item_name; ?>
                                                                            </h4>
                                                                            <?php echo $l_badge; ?>


                                                                            <div class="row mb-3 mt-3">
                                                                                <div class="col-6">
                                                                                    <p class="mb-1 text-muted">ID Barang</p>
                                                                                    <p class="fw-bold">
                                                                                        <?php echo $l_id; ?>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <p class="mb-1 text-muted">Tanggal Dilaporkan
                                                                                    </p>
                                                                                    <p class="fw-bold">
                                                                                        <?php echo $l_date; ?>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <p class="mb-1 text-muted">Lokasi</p>
                                                                                    <p class="fw-bold">
                                                                                        <?php echo $l_location; ?>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <p class="mb-1 text-muted">Dilaporkan Oleh</p>
                                                                                    <p class="fw-bold"><? echo $ul_full_name; ?></p>
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <p class="mb-1 text-muted">Deskripsi</p>
                                                                                <p>
                                                                                    <?php echo $l_description; ?>
                                                                                </p>
                                                                            </div>

                                                                            <div class="mb-4">
                                                                                <p class="mb-1 text-muted">Kontak Pelapor</p>
                                                                                <p><i
                                                                                        class="fas fa-phone me-2"></i><?php echo $ul_phone; ?>
                                                                                </p>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
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

                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#verificationCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>

                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#verificationCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center">

                                <form id="verifyForm"method="post" class="d-flex justify-content-center gap-3 flex-wrap">

                                    <input type="hidden" name="matching_id" id="matching_id">

                                    <button type="submit" class="btn btn-outline-success btn-lg px-4" name="action"
                                        value="verify" <?= $disableBtn ?>>
                                        <i class="fas fa-check me-2"></i> Verifikasi
                                    </button>

                                    <button type="submit" class="btn btn-outline-danger btn-lg px-4" name="action"
                                        value="mismatch" <?= $disableBtn ?>>
                                        <i class="fas fa-times me-2"></i> Tidak Sama
                                    </button>

                                </form>

                            </div>
                        </div>


                    </div>
                </section>
            <?php } ?>
        </div>
    </div>

    <script>
        document.getElementById("verifyForm").addEventListener("submit", function () {

            const match = document.querySelector("#verificationCarousel .carousel-item.active");

            const matchId = match.dataset.id;
            

            document.getElementById("matching_id").value = matchId;

        });
    </script>
</body>

</html>