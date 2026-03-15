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
?>

<?php
session_start();
if (!$_SESSION["user_id"])
   header("location:login.php");

include "connection.php";

if (isset($_GET['id_user'])) {
   $id_user = $_GET['id_user'];

   $sql = " ";
   $sql = " delete from tb_users where id_user= '$id_user'";
   if (mysqli_query($conn, $sql))
      header("location:users.php");
}
