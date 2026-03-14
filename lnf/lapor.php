<?php
include "connection.php";
if (isset($_POST['btnSubmit'])) {

    $reported_by = 1;
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    </style>
</head>

<body>
    <?php include "navbarr.php"; ?>
    <main class="flex-fill container py-5">
        <section class="component-card">
            <h4 class="mt-4">Upload Data Barang Hilang</h4>
            <div class="wireframe-box">
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" placeholder="Contoh: Dompet kulit coklat" name="item_name" id="item_name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="category" id="category" required>
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
                                <input type="text" class="form-control" placeholder="Contoh: Stasiun Sudirman, Gerbong 3">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Penemuan</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" rows="3" placeholder="Deskripsi detail barang..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Upload Foto</label>
                                <div class="border rounded p-4 text-center">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3"></i>
                                    <p>Drag & drop atau klik untuk upload</p>
                                    <button class="btn btn-outline-secondary btn-sm">Pilih File</button>
                                </div>
                                <p class="text-muted mt-2"><small>Format: JPG, PNG. Maksimal 5MB</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-secondary me-2">Batal</button>
                        <button class="btn btn-accent">Upload Barang</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php include "footer.php"; ?>
</body>

</html>