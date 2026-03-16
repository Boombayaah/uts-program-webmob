<?php
include '../config/connection.php';

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
            VALUES (3, '$nik', '$full_name', $email, '$phone', '$hash')";

    if (mysqli_query($conn, $sql)) {
        // FITUR REDIRECT: Munculkan alert lalu pindah ke login_page.php
        echo "<script>
                alert('Pendaftaran Berhasil! Silakan Login.'); 
                window.location.href='login_page.php';
              </script>";
    } else {
        echo "<script>alert('Terjadi kesalahan sistem!'); window.history.back();</script>";
    }
}
