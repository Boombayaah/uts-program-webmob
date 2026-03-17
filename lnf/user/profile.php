<?php
session_start();

// GANTI PENGECEKAN KE USER_ID
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login_page.php");
    exit();
}

include '../config/connection.php';

$uid = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$uid'"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email_baru = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_baru = mysqli_real_escape_string($conn, $_POST['phone']);
    $confirm_password = $_POST['confirm_password'];

    // Verifikasi password jika mengubah data sensitif
    if ($email_baru != $user['email'] || $phone_baru != $user['phone']) {
        if (!password_verify($confirm_password, $user['password_hash'])) {
            echo "<script>alert('Password konfirmasi salah!'); window.location='profile.php';</script>";
            exit();
        }
    }

    if (!empty($_FILES['fileToUpload']['name'])) {
        $target_dir = "../assets/images/profile/uploads/";
        $file_name = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $sql = "UPDATE users 
                    SET profile_image = '$file_name'
                    WHERE user_id ='$uid'";
            mysqli_query($conn, $sql);
        }
    }

    $sql = "UPDATE users SET full_name='$full_name', email='$email_baru', phone='$phone_baru' WHERE user_id='$uid'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='profile.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Perbaikan posisi mata password agar presisi di tengah vertikal */
        .password-container {
            position: relative;
            width: 100%;
            display: flex;
            /* Menggunakan flexbox untuk penyelarasan */
            align-items: center;
            /* Meratakan elemen secara vertikal */
        }

        .password-container input {
            width: 100%;
            padding-right: 45px !important;
            /* Ruang agar teks tidak tertutup ikon */
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            /* Letakkan di tengah tinggi container */
            transform: translateY(-50%);
            /* Geser balik ke atas 50% dari tinggi ikon sendiri */
            cursor: pointer;
            color: #888;
            z-index: 10;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            /* Menghilangkan spasi font-awesome agar tidak miring */
        }
    </style>

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
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="../admin-page/dashboard.php" class="btn-home">Back To Page</a>

            <div class="profile-circle" style="margin: 0 auto 20px;">
                <?php $image_source = "../assets/images/profile/";
                if (!empty($user['profile_image'])) {
                    $image_source .= "uploads/";
                    $image_source .= $user['profile_image'];
                } else {
                    $image_source .= 'default-avatar.jpg';
                }
                ?>
                <img src="<?php echo $image_source; ?>" alt="Profile Image" class="img-fluid rounded-circle" width="60" height="60">
            </div>
            <h2><?php echo $user['full_name']; ?></h2>
            <form method="POST" id="profileForm" enctype="multipart/form-data">
                <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" readonly required placeholder="Nama Lengkap">
                <input type="email" name="email" value="<?php echo $user['email']; ?>" readonly placeholder="Email (Opsional)">
                <input type="text" name="phone" value="<?php echo $user['phone']; ?>" readonly required placeholder="Nomor Telepon" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                <div id="confirmArea" style="display: none;">
                    <div class="mb-3 mt-3">
                        <label for="reg_pass">Profile Image:</label>
                        <br>
                        <input type="file" id="fileToUpload" name="fileToUpload">
                    </div>
                    <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
                        <p style="font-size: 11px; color: red; text-align: left; margin-bottom: 5px;">Konfirmasi Password Akun:</p>
                        <div class="password-container">
                            <input type="password" name="confirm_password" id="p_conf" placeholder="Password">
                            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('p_conf', this)"></i>
                        </div>
                    </div>
                </div>
                <?php if ($_SESSION['role_id'] == 3) {
                    echo '<button type="button" id="ebtn" class="btn-primary" onclick="enableEdit()" style="background-color: #6c757d; margin-top: 15px;">Ubah Informasi Akun</button>';
                    echo '<button type="submit" id="sbtn" class="btn-primary" style="display: none; margin-top: 15px;">Simpan Perubahan</button>';
                }
                ?>
            </form>
        </div>
    </div>
    <script>
        function enableEdit() {
            document.querySelectorAll('#profileForm input').forEach(i => {
                if (i.name !== 'confirm_password') i.readOnly = false;
            });
            document.getElementById('ebtn').style.display = 'none';
            document.getElementById('sbtn').style.display = 'block';
            document.getElementById('confirmArea').style.display = 'block';
        }

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