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

if (isset($_GET['category'])) {
   $category = $_GET['category'];

   $sql = "";
   $sql = "DELETE FROM users WHERE category = '$category'";
   if (mysqli_query($conn, $sql))
      header("location:categorymanagement.php");
}
