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
    $cek = mysqli_query($conn, "SELECT user_id FROM users WHERE nik = '$nik' OR phone = '$phone'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('NIK atau Nomor Telepon sudah terdaftar!'); window.history.back();</script>";
        exit();
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $sql = "INSERT INTO users (role_id, nik, full_name, email, phone, password_hash) 
            VALUES (2, '$nik', '$full_name', $email, '$phone', '$hash')";

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
</head>

<body>
    <?php
    if (isset($_POST['btnSubmit'])) {
        include "../config/connection.php";

        $target_dir = "../assets/images/profile/uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $uploadOk = 0;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $uploadOk = 1;
            $file_name = $_FILES["profile_image"]["name"];
        } else {
            $uploadOk = 0;
            $file_name = "";
        }

        // Logika buat ngubah 0 jadi 62
        // $phone = $_POST['phone'];
        // $start_number = substr($phone, 0, 1);
        // if ($start_number == 0) {
        //     $tmp = $phone;
        //     $
        // }

        $password_hash = md5($_POST['user_password']);
        $sql = "";
        $sql = "INSERT INTO users (role_id, nik, profile_image, full_name, email, phone, password_hash)";
        $sql .= " VALUES (2, '$_POST[nik]', '$file_name', '$_POST[full_name]', '$_POST[email]', '$_POST[phone]', '$password_hash'";

        if (mysqli_query($conn, $sql)) {
            header("location:adminmanagement.php");
        }
    }
    ?>
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
                                        <input type="text" name="nik" class="form-control" placeholder="NIK (16 Digit)" required maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="phone">Full Name:</label>
                                        <input type="text" name="full_name" class="form-control" placeholder="Nama Lengkap" required>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="phone">Email:</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email Address (Opsional)">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="phone">Nomor Telepon:</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Nomor Telepon" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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
</body>

</html>