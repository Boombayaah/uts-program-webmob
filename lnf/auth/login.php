<?php
session_start();
include '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']);
    $password = $_POST['password'];

    // Query mencari di TIGA kolom sekaligus: email, phone, atau nik
    $query = "SELECT * FROM users WHERE email = '$identifier' OR phone = '$identifier' OR nik = '$identifier'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role_id'] = $user['role_id'];

        if ($user['role_id'] == 1) {
            header("location: ../admin_leader-page/dashboardleader.php");
            exit();
        } else if ($user['role_id'] == 2) {
            header("location: ../admin-page/dashboard.php");
            exit();
        } else {
            header("location: ../index.php");
            exit();
        }
    } else {
        echo "<script>alert('Data login atau Password salah!'); window.history.back();</script>";
    }
}
