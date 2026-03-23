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

$sql_category = "SELECT * 
                FROM item_category
                ORDER BY category";
$hasil_category = mysqli_query($conn, $sql_category);

$file_name = "";

if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
    $file_name = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    move_uploaded_file($tmp_name, "../assets/images/uploads" . $file_name);
}


$limit = 7;

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $limit;

$sql = "select * from found_items LIMIT $start,$limit";
$hasil = mysqli_query($conn, $sql);

$sql_total = "select count(*) as total from found_items";
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

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin-page.css">

    <script>
        $(document).ready(function() {
            $("#searchBar").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tableData tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {

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

        function delete_confirm() {
            if (confirm("Are you sure?"))
                return true;
            else
                return false;
        }
    </script>

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
                            <option value="">Pilih kategori</option>

                            <?php
                            foreach ($hasil_category as $single_category) {
                                echo "<option value='$single_category[category]'>$single_category[category]</option>";
                            }
                            ?>
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
                                <th>Operasi</th>
                            </tr>
                        </thead>
                        <tbody id="tableData">
                            <?php
                            if (mysqli_num_rows($hasil) > 0) {
                                while ($row = mysqli_fetch_assoc($hasil)) {
                                    $id = $row['found_item_id'];
                                    $tanggal = $row['found_date'];
                                    $laporan = $row['item_name'];
                                    $kategori = $row['category'];
                                    $keterangan = $row['description'];
                                    $lokasi = $row['location'];
                                    $bukti = $row['file'];
                                    $status = $row['status'];

                                    $badge = "";

                                    if ($status == "Diproses") {
                                        $badge = '<span class="status-badge me-2" style="background-color: #FEF3C7; color: #92400E;">
                                                        <i class="fas fa-clock me-1"></i>Sedang Diproses
                                                    </span>';
                                    } elseif ($status == "Menunggu Verifikasi Atasan") {
                                        $badge = '<span class="status-badge me-2" style="background-color: #DBEAFE; color: #1E40AF;">
                                                        <i class="fas fa-exchange-alt me-1"></i>Menunggu Verifikasi
                                                    </span>';
                                    } elseif ($status == "Dibatalkan") {
                                        $badge = '<span class="status-badge me-2" style="background-color: #D1FAE5; color: #991B1B;">
                                                        <i class="fas fa-check-circle me-1"></i>Dibatalkan
                                                    </span>';
                                    } elseif  ($status == "Diserahkan")  {
                                        $badge = '<span class="status-badge me-2" style="background-color: #D1FAE5; color: #065F46;">
                                                            <i class="fas fa-check-circle me-1"></i>Diserahkan
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
                                                <a href="../assets/images/uploads/<?php echo $bukti; ?>" target="_blank">Lihat Gambar</a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $badge; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="temuan_edit.php?found_item_id=<?php echo $id ?>"><i
                                                    class="button-text-icon fa-regular fa-pen-to-square m-1"
                                                    style="color: #f59e0b;"></i></a>
                                            <a href="delete_laporan.php?type=found&id=<?php echo $id ?>"
                                                onclick="return delete_confirm();"><i
                                                    class="button-text-icon fa-regular fa-trash-can m-1"
                                                    style="color: #f59e0b;"></i></a>
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
                                <a href="laporan_temuan.php?page=<?php echo $page - 1; ?>" class="page-link">Prev</a>
                            </li>

                            <!-- halaman -->
                            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                <li class="page-item <?php if ($i == $page)
                                                            echo 'active'; ?>">
                                    <a href="laporan_temuan.php?page=<?php echo $i; ?>" class="page-link">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <!-- next -->
                            <li class="page-item <?php if ($page >= $total_page)
                                                        echo 'disabled' ?>">
                                <a href="laporan_temuan.php?page=<?php echo $page + 1; ?>" class="page-link">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>