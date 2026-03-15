<?php
session_start();
include "../config/connection.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 2) {
        header("Location: ../admin-page/dashboard.php");
    } else {
        header("Location: ../home.php");
    }
    exit();
}

if (isset($_GET['user_id'])) {
   $user_id = $_GET['user_id'];

   $sql = "";
   $sql = "DELETE FROM users WHERE id_user= '$user_id'";
   if (mysqli_query($conn, $sql))
      header("location:adminmanagement.php");
}
