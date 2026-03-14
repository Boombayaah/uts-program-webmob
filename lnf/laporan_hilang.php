<?php
session_start();
$logged_in = isset($_SESSION['user_id']);
include "config/connection.php";
if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
    $file_name = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    move_uploaded_file($tmp_name, "uploads/" . $file_name);
}

$limit = 7;

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $limit;

$sql = "select * from lost_reports LIMIT $start,$limit";
$hasil = mysqli_query($conn, $sql);

$sql_total = "select count(*) as total from lost_reports";
$results_total = mysqli_query($conn, $sql_total);
$data_total = mysqli_fetch_assoc($results_total);

$total_data = $data_total['total'];

$total_page = ceil($total_data / $limit);
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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

        .col-keterangan {
            max-width: 400px;
            word-wrap: break-word;
        }

        #sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #000;
            font-size: 16px;
            padding: 10px 12px;
            border-radius: 6px;
        }

        #sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
        }

        #sidebar-nav .nav-link:hover {
            background-color: #f2f2f2;
        }

        #sidebar-nav .nav-link.active {
            color: #2f6fed;
            font-weight: 600;
        }

        .sidebar-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: #2c4c8c;
        }

        .sidebar-title i {
            font-size: 26px;
            color: #2f6fed;
        }

        .sidebar-title span {
            font-size: 22px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $("#searchBar").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#tableData tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {

            const searchBar = document.getElementById("searchBar");
            const statusFilter = document.getElementById("statusFilter"); // tambahin id di select
            const categoryFilter = document.getElementById("categoryFilter"); // tambahin id di select
            const tableRows = document.querySelectorAll("#tableData tr");

            function filterTable() {
                const searchValue = searchBar.value.toLowerCase();
                const statusValue = statusFilter.value.toLowerCase();
                const categoryValue = categoryFilter.value.toLowerCase();

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const status = row.querySelector("td:nth-child(7)").textContent.toLowerCase(); // kolom status
                    const category = row.querySelector("td:nth-child(3)").textContent.toLowerCase(); // kolom kategori

                    const matchesSearch = text.includes(searchValue);
                    const matchesStatus = statusValue === "" || status.includes(statusValue);
                    const matchesCategory = categoryValue === "" || category.includes(categoryValue);

                    row.style.display = matchesSearch && matchesStatus && matchesCategory ? "" : "none";
                });
            }

            searchBar.addEventListener("keyup", filterTable);
            statusFilter.addEventListener("change", filterTable);
            categoryFilter.addEventListener("change", filterTable);

        });
    </script>
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
                            <a class="nav-link active" href="laporan_hilang.php">
                                <i class="fas fa-box-open me-2"></i> Barang Hilang
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link" href="laporan_temuan.php">
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


            <div class="col-md-9 col-lg-10 mt-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input id="searchBar" type="text" class="form-control"
                                placeholder="Cari barang atau laporan...">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="sedang diproses">Sedang Diproses</option>
                            <option value="telah ditemukan">Telah Ditemukan</option>
                            <option value="menunggu pengambilan">Menunggu Pengambilan</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select class="form-select" id="categoryFilter">
                            <option value="">Semua Kategori</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="dompet & tas">Dompet & Tas</option>
                            <option value="dokumen">Dokumen</option>
                            <option value="aksesoris">Aksesoris</option>
                            <option value="kunci">Kunci</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Tanggal</th>
                                <th>Laporan</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Lokasi</th>
                                <th>Bukti Barang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableData">
                            <?php
                            if (mysqli_num_rows($hasil) > 0) {
                                while ($row = mysqli_fetch_assoc($hasil)) {
                                    $tanggal = $row['lost_date'];
                                    $laporan = $row['item_name'];
                                    $kategori = $row['category'];
                                    $keterangan = $row['description'];
                                    $lokasi = $row['location'];
                                    $bukti = $row['file'];
                                    $status = $row['status'];

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
                                    <tr class="text-center">
                                        <td>
                                            <?php echo $tanggal; ?>
                                        </td>
                                        <td>
                                            <?php echo $laporan; ?>
                                        </td>
                                        <td>
                                            <?php echo $kategori; ?>
                                        </td>
                                        <td class="col-keterangan">
                                            <?php echo $keterangan; ?>
                                        </td>
                                        <td>
                                            <?php echo $lokasi; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($bukti == "") {
                                                echo "";
                                            } else {
                                                ?>
                                                <a href="uploads/<?php echo $bukti; ?>" target="_blank">Lihat Gambar</a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $badge; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                mysqli_free_result($hasil);
                            }
                            ?>
                        </tbody>

                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        <ul class="pagination">
                            <!-- prev -->
                            <li class="page-item <?php if ($page <= 1)
                                echo 'disabled'; ?>">
                                <a href="index.php?page=<?php echo $page - 1; ?>" class="page-link">Prev</a>
                            </li>

                            <!-- halaman -->
                            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                <li class="page-item <?php if ($i == $page)
                                    echo 'active'; ?>">
                                    <a href="index.php?page=<?php echo $i; ?>" class="page-link">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <!-- next -->
                            <li class="page-item <?php if ($page >= $total_page)
                                echo 'disabled' ?>">
                                    <a href="index.php?page=<?php echo $page + 1; ?>" class="page-link">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>