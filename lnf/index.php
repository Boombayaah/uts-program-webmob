<?php
include "navbarr.php";
include 'config/connection.php';
if (isset($_POST['btnSubmit'])) {
    
    $reported_by = $_SESSION['user_id'];

    $q = mysqli_query($conn, "SELECT full_name FROM users WHERE user_id = '$reported_by'");
    $user = mysqli_fetch_assoc($q);
    $full_name = $user['full_name'];

    $file_name = "";

    if ($_FILES['file']['name'] != "") {
        $file_name = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];

        move_uploaded_file($tmp_name, "uploads/" . $file_name);
    }

    $sql = "insert into lost_reports (reported_by, item_name, category, description, location, lost_date, file)";
    $sql .= "values ('$reported_by', '$_POST[item_name]', '$_POST[category]', '$_POST[description]', '$_POST[location]', '$_POST[lost_date]', '$file_name')";

    if (mysqli_query($conn, $sql)) {
        header("location:index.php");
    } else {
        echo "Error" . mysqli_error($conn);
    }

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
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        .main-container {
            max-width: 1600px;
            margin: auto;
            padding-left: 40px;
            padding-right: 40px;
        }

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

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
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

        .btn-outline-accent {
            border: 2px solid var(--accent-color);
            color: #92400E;
            /* lebih gelap dari kuning */
            background: white;
        }

        .btn-outline-accent:hover {
            background: var(--accent-color);
            color: white;
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

        .navbar .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }

        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
        }

        .navbar .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            display: block;
        }

        .col-keterangan {
            max-width: 400px;
            word-wrap: break-word;
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
                    const matchesCategory = categoryValue === "" || category === categoryValue;

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



    <main class="flex-fill container-fluid">
        <div class="main-container mt-4">
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
                        <option value="dompet-tas">Dompet & Tas</option>
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
                                    <td><?php echo $tanggal; ?></td>
                                    <td><?php echo $laporan; ?></td>
                                    <td><?php echo $kategori; ?></td>
                                    <td class="col-keterangan"><?php echo $keterangan; ?></td>
                                    <td><?php echo $lokasi; ?></td>
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
                                    <td><?php echo $badge; ?></td>
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
    </main>

    <section id="lapor" class="position-relative py-5 text-black overflow-hidden mt-5">

        <!-- background svg -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="
            background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
            opacity: 0.5;
            background-repeat: repeat;
        "></div>

        <!-- content -->
        <div class="main-container text-center position-relative py-4" style="z-index: 10;">
            <h2 class="display-5 fw-bold mb-3 text-black">Kehilangan Barang atau Menemukan Sesuatu?</h2>
            <p class="lead mb-4 mx-auto" style="max-width: 700px;">
                Bergabunglah dengan komunitas peduli kami. Setiap barang memiliki cerita dan pemilik yang merindukannya.
            </p>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <?php if ($logged_in): ?>

                    <button type="button" class="btn btn-outline-warning text-black fw-semibold px-4 py-2 rounded-3 mt-3"
                        data-bs-toggle="modal" data-bs-target="#reportModal">

                        <i class="bi bi-exclamation-circle"></i>
                        Laporkan Kehilangan
                    </button>

                <?php else: ?>

                    <a href="auth/login_page.php"
                        class="btn btn-outline-warning text-black fw-semibold px-4 py-2 rounded-3 mt-3">

                        <i class="bi bi-exclamation-circle"></i>
                        Laporkan Kehilangan
                    </a>

                <?php endif; ?>
            </div>
        </div>
    </section>

    <main class="flex-fill container">
        <section class="py-0">
            <div class="modal fade" id="reportModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="mt-4">Upload Data Barang Hilang</h4>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" class="w-100">

                                <div class="wireframe-box">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Barang</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Contoh: Dompet kulit coklat" name="item_name"
                                                    id="item_name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Kategori</label>
                                                <select class="form-select" name="category" id="category">
                                                    <option value="">Pilih kategori</option>
                                                    <option value="elektronik">Elektronik</option>
                                                    <option value="dompet-tas">Dompet & Tas</option>
                                                    <option value="dokumen">Dokumen</option>
                                                    <option value="aksesoris">Aksesoris</option>
                                                    <option value="kunci">Kunci</option>
                                                    <option value="lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Lokasi Kehilangan</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Contoh: Stasiun Sudirman, Gerbong 3" name="location"
                                                    id="location" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Kehilangan</label>
                                                <input type="date" class="form-control" name="lost_date" id="lost_date"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control" rows="3"
                                                    placeholder="Deskripsi detail barang..." name="description"
                                                    id="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Upload Foto</label>
                                                <div class="border rounded p-4 text-center" id="uploadArea"
                                                    style="cursor: pointer;">
                                                    <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3"></i>
                                                    <p>Klik untuk upload</p>
                                                    <button class="btn btn-outline-secondary btn-sm"
                                                        id="uploadBtn">Pilih File</button>
                                                </div>
                                                <p class="text-muted mt-2"><small>Format: JPG, PNG. Maksimal 5MB</small>
                                                </p>
                                                <input type="file" class="d-none" id="fileInput" name="file"
                                                    accept=".jpg, .png">
                                                <p class="mt-2" id="fileName"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                                        <button class="btn btn-accent" name="btnSubmit">Upload Barang</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </main>


    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const fileInput = document.getElementById('fileInput');
        const uploadBtn = document.getElementById('uploadBtn');
        const uploadArea = document.getElementById('uploadArea');
        const fileName = document.getElementById('fileName');

        // klik tombol atau area → trigger input file
        uploadBtn.addEventListener('click', () => fileInput.click());
        uploadArea.addEventListener('click', (e) => {
            if (e.target.id !== 'uploadBtn') fileInput.click();
        });

        // tampilkan nama file yg dipilih
        fileInput.addEventListener('change', () => {
            fileName.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : '';
        });
    </script>
</body>

</html>