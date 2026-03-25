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

$limit = 7;

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $limit;

$sql = "SELECT * FROM item_category LIMIT $start, $limit";
$hasil = mysqli_query($conn, $sql);

$sql_total = "SELECT count(*) AS total FROM item_category";
$results_total = mysqli_query($conn, $sql_total);
$data_total = mysqli_fetch_assoc($results_total);

$total_data = $data_total['total'];

$total_page = ceil($total_data / $limit);

// TAMBAH KATEGORI
if (isset($_POST['add_category'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $check = mysqli_query($conn, "SELECT * FROM item_category WHERE category='$category'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Kategori sudah ada!');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO item_category(category) VALUES('$category')");
        echo "<script>window.location='';</script>";
    }
}

// EDIT KATEGORI
if (isset($_POST['edit_category'])) {
    $old = $_POST['old_category'];
    $new = mysqli_real_escape_string($conn, $_POST['category']);

    mysqli_query($conn, "UPDATE item_category SET category='$new' WHERE category='$old'");
    echo "<script>window.location='';</script>";
}

// DELETE
if (isset($_GET['delete'])) {
    $del = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM item_category WHERE category='$del'");
    echo "<script>window.location='categorymanagement.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commuter | Manajemen Kategori Barang</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin-page.css">

    <style>
        .button-text-icon:hover {
            color: #624004 !important;
        }

        .button-new-icon:hover {
            background-color: #9EC1FA !important;
            color: black !important;
        }

        .input-group.rounded-pill {
            border-radius: 50px;
            overflow: hidden;
        }

        .input-group.rounded-pill input {
            box-shadow: none !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Modal Box -->
    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        function delete_confirm() {
            if (confirm('Yakin menghapus kategori ini?'))
                return true;
            else
                return false;
        }

        function openEditModal(category) {
            document.getElementById('old_category').value = category;
            document.getElementById('edit_category').value = category;

            var modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
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
            <?php include "leader_sidebar.php"; ?>
            <div class="col-md-9 col-lg-10 main-content">
                <h4 class="mt-4">Manajemen Kategori Barang</h4>
                <div class="wireframe-box">
                    <div class="row">
                        <div class="col-sm-6 col-md-12">
                            <div class="dashboard-card table-responsive" style="background-color: #EFF6FF;">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <button class="button-new-icon btn text-white px-4"
                                        style="background-color: #3b82f6;"
                                        data-bs-toggle="modal" data-bs-target="#addModal">
                                        NEW CATEGORY
                                    </button>
                                    <div class="input-group rounded-pill shadow-sm px-2 bg-white" style="max-width:350px;">
                                        <span class="input-group-text bg-white border-0">
                                            <i class="fa fa-search text-secondary"></i>
                                        </span>
                                        <input
                                            id="myInput"
                                            type="text"
                                            class="form-control border-0 rounded-end-pill"
                                            placeholder="Search here ...">
                                    </div>
                                </div>
                                <table class="table table-hover">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">Category</th>
                                            <th scope="col">Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable" class="table-group-divider">
                                        <?php
                                        $sql = "";
                                        $sql = "SELECT * FROM item_category";
                                        $result = mysqli_query($conn,  $sql);
                                        $i = 1;
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $category = $row['category'];
                                        ?>
                                                <tr class="align-middle">
                                                    <td scope="row"><?php echo $category; ?></td>
                                                    <td class="text-center">
                                                        <i class="button-text-icon fa-regular fa-pen-to-square m-1"
                                                            style="color: #f59e0b; cursor:pointer;"
                                                            onclick="openEditModal('<?php echo $category ?>')"></i>
                                                        <a href="?delete=<?php echo $category ?>" onclick="return delete_confirm();"><i class="button-text-icon fa-regular fa-trash-can m-1" style="color: #f59e0b;"></i></a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                            mysqli_free_result($result);
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <ul class="pagination">
                            <!-- prev -->
                            <li class="page-item <?php if ($page <= 1)
                                                        echo 'disabled'; ?>">
                                <a href="<?php echo basename($_SERVER['PHP_SELF']) ?>?page=<?php echo $page - 1; ?>" class="page-link">Prev</a>
                            </li>

                            <!-- halaman -->
                            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                <li class="page-item <?php if ($i == $page)
                                                            echo 'active'; ?>">
                                    <a href="<?php echo basename($_SERVER['PHP_SELF']) ?>?page=<?php echo $i; ?>" class="page-link">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <!-- next -->
                            <li class="page-item <?php if ($page >= $total_page)
                                                        echo 'disabled' ?>">
                                <a href="<?php echo basename($_SERVER['PHP_SELF']) ?>?page=<?php echo $page + 1; ?>" class="page-link">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD MODAL -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="category" class="form-control" placeholder="Nama kategori" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_category" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="old_category" id="old_category">
                        <input type="text" name="category" id="edit_category" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="edit_category" class="btn" style="background-color: #f59e0b; color: #1E3A8A;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>