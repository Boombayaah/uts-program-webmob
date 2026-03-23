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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);

    $target_dir = "../assets/images/profile/uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 0;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $uploadOk = 1;
        $file_name = $_FILES["fileToUpload"]["name"];
    } else {
        $uploadOk = 0;
        $file_name = "";
    }

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);

    // Email opsional
    $email = !empty($_POST['email']) ? "'" . mysqli_real_escape_string($conn, $_POST['email']) . "'" : "NULL";

    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Password tidak cocok!'); window.history.back();</script>";
        exit();
    }

    // Cek duplikasi data
    $cek = mysqli_query($conn, "SELECT user_id FROM users WHERE nik = '$nik' OR phone = '$phone' OR email = $email");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('NIK atau Nomor Telepon atau Email telah terdaftar!'); window.history.back();</script>";
        exit();
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $sql = "INSERT INTO users (role_id, nik, profile_image, full_name, email, phone, password_hash) 
            VALUES (2, '$nik', '$file_name', '$full_name', $email, '$phone', '$hash')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Penambahan akun admin berhasil!'); 
                window.location.href='adminmanagement.php';
              </script>";
    } else {
        echo "<script>alert('Terjadi kesalahan sistem!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* CSS Tambahan agar harmoni dengan Bootstrap */
        .password-container {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .password-container input {
            padding-right: 45px !important;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            z-index: 10;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
    </style>

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                el.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                el.classList.replace("fa-eye-slash", "fa-eye");
            }
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
                <h4 class="mt-4">Penambahan Akun Admin</h4>
                <div class="wireframe-box">
                    <div class="row">
                        <div class="col-sm-6 col-md-12">
                            <div class="dashboard-card table-responsive" style="background-color: #EFF6FF;">
                                <h1 class="h1 text-center">Informasi Admin Baru</h1>
                                <form action="add_admin.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-3 mt-3">
                                        <label for="phone">NIK:</label>
                                        <input type="text" name="nik" class="form-control" placeholder="NIK (16 digit)" required maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="phone">Nama Lengkap:</label>
                                        <input type="text" name="full_name" class="form-control" placeholder="Nama Lengkap" required>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="phone">Email:</label>
                                        <input type="email" name="email" class="form-control" placeholder="Alamat email (opsional)">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="phone">Nomor Telepon:</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Nomor telepon" maxlength="16" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="reg_pass">Password:</label>
                                        <div class="password-container">
                                            <input type="password" name="password" id="reg_pass" class="form-control" placeholder="Password" required>
                                            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('reg_pass', this)"></i>
                                        </div>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="reg_confirm">Confirm Password:</label>
                                        <div class="password-container">
                                            <input type="password" name="confirm_password" id="reg_confirm" class="form-control" placeholder="Konfirmasi Password" required>
                                            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('reg_confirm', this)"></i>
                                        </div>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="fileToUpload">Profile Picture:</label>
                                        <input type="file" id="fileToUpload" name="fileToUpload" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="btnSubmit">Submit</button>

                                    <a href="adminmanagement.php">
                                        <button type="button" class="btn btn-danger">Cancel</button>
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>