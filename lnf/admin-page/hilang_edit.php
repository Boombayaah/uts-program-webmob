<?php
session_start();
include "../config/connection.php";
$logged_in = isset($_SESSION['user_id']);

$sql_category = "SELECT * 
                FROM item_category
                ORDER BY category";
$hasil_category = mysqli_query($conn, $sql_category);

if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 1) {
    header("Location: ../admin_leader-page/dashboardleader.php");
    exit();
} else if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 3) {
    header("Location: ../home.php");
    exit();
} 


if (isset($_GET['lost_report_id']))
    {
        $id = $_GET['lost_report_id'];
        $sql = "select * from lost_reports where lost_report_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
    }

if (isset($_POST['btnSubmit'])) {

    $id = $_POST['lost_report_id'];

    $item_name = $_POST['item_name'];
    $kategori = $_POST['category'];
    $lokasi = $_POST['location'];
    $tanggal = $_POST['lost_date'];
    $deskripsi = $_POST['description'];

    $file_name = "";

    if ($_FILES['file']['name'] != "") {
        $file_name = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];

        move_uploaded_file($tmp_name, "uploads/" . $file_name);
    }

    $sql = "UPDATE lost_reports
            set item_name = '$item_name',
                category = '$kategori',
                location = '$lokasi',
                lost_date = '$tanggal',
                description = '$deskripsi'
                WHERE lost_report_id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("location:laporan_hilang.php");
    } else {
        echo "Error" . mysqli_error($conn);
    }
}

if (isset($_POST['btnCancel'])) {
    header("Location: laporan_hilang.php");
    exit();
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin-page.css">

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
    <div class="container-fluid">
        <div class="row">
            <?php include "admin_sidebar.php"; ?>
            <div class="col-md-9 col-lg-10 main-content">
                <h4 class="mt-4">Edit Barang Hilang</h4>
                <form method="post" enctype="multipart/form-data" class="w-100">
                    <div class="wireframe-box">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="hidden" name="lost_report_id" value="<?= $id ?>">
                                    <input type="text" class="form-control" value="<?php echo $data['item_name'];?>"
                                        name="item_name" id="item_name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-select" name="category" id="category" >
                                        <option value="<?php echo $data['category'];?>"><?php echo $data['category'];?></option>

                                        <?php
                                        foreach ($hasil_category as $single_category) {
                                            echo "<option value='$single_category[category]'>$single_category[category]</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lokasi Kehilangan</label>
                                    <input type="text" class="form-control"
                                        value="<?php echo $data['location'];?>" name="location" id="location"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Kehilangan</label>
                                    <input type="date" class="form-control" value="<?php echo $data['lost_date'];?>" name="lost_date" id="lost_date" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" rows="3" value=""
                                        name="description" id="description"><?php echo $data['description'];?></textarea>
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
                            <button class="btn btn-secondary me-2" name="btnCancel">Batal</button>
                            <button class="btn btn-accent" name="btnSubmit">Submit</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</body>

</html>