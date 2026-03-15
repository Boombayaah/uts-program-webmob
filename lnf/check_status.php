<?php
session_start();
include "config/connection.php";
$logged_in = isset($_SESSION['user_id']);

if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 1) {
    header("Location: dashboardleader.php");
} else if (isset($_SESSION['user_id']) && $_SESSION['role_id'] == 2) {
    header("Location: dashboard.php");
} else {
    header("Location: index.php");
}
exit();
