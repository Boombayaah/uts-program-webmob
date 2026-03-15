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

    $sql = "insert into found_items (reported_by, item_name, category, description, location, found_date, file)";
    $sql .= "values ('$reported_by', '$_POST[item_name]', '$_POST[category]', '$_POST[description]', '$_POST[location]', '$_POST[found_date]', '$file_name')";

    if (mysqli_query($conn, $sql)) {
        header("location:laporan_temuan.php");
    } else {
        echo "Error" . mysqli_error($conn);
    }
}
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
                            <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link active" href="upload_barang.php">
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
                <h4 class="mt-4">Upload Barang Temuan</h4>
                <form method="post" enctype="multipart/form-data" class="w-100">
                    <div class="wireframe-box">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" placeholder="Contoh: Dompet kulit coklat"
                                        name="item_name" id="item_name" required>
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
                                    <label class="form-label">Lokasi Penemuan</label>
                                    <input type="text" class="form-control"
                                        placeholder="Contoh: Stasiun Sudirman, Gerbong 3" name="location" id="location"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Penemuan</label>
                                    <input type="date" class="form-control" name="found_date" id="found_date" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" rows="3" placeholder="Deskripsi detail barang..."
                                        name="description" id="description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Upload Foto</label>
                                    <div class="border rounded p-4 text-center" id="uploadArea"
                                        style="cursor: pointer;">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3"></i>
                                        <p>Klik untuk upload</p>
                                        <button class="btn btn-outline-secondary btn-sm" id="uploadBtn">Pilih
                                            File</button>
                                    </div>
                                    <p class="text-muted mt-2"><small>Format: JPG, PNG. Maksimal 5MB</small></p>
                                    <input type="file" class="d-none" id="fileInput" name="file" accept=".jpg, .png">
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