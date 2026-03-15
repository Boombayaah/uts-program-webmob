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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include "leader_sidebar.php" ?>
    <?php
    if (isset($_POST['btnSubmit'])) {
        include "../config/connection.php";

        $target_dir = "../assets/images/profile/uploads/";
        $target_file .= basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 0;

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $uploadOk = 1;
            $file_name = $_FILES["fileToUpload"]["name"];
        } else {
            $uploadOk = 0;
            $file_name = "";
        }

        $sql = "";
        $sql = "INSERT INTO users (role_id, nik, profile_image, full_name, email, phone, password_hash)";
        $sql .= " VALUES (2, '$_POST[nik]', '$file_name', '$_POST[full_name]', '$_POST[email]', '$_POST[phone]', md5($_POST[user_password])";

        if (mysqli_query($conn, $sql))
            header("location:adminmanagement.php");
    }
    ?>

    <div class="container">
        <h1 class="h1 text-center">Add New User</h1>

        <form action="add_user.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="nm_user">User Name:</label>
                <input type="text" class="form-control" id="nm_user" placeholder="Enter user name" name="nm_user" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="email_account">Email:</label>
                <input type="email" class="form-control" id="email_account" placeholder="Enter email" name="email_account" required>
            </div>
            <div class="mb-3">
                <label for="user_password">Password:</label>
                <input type="password" class="form-control" id="user_password" placeholder="Enter password" name="user_password" required>
            </div>

            <div class="mb-3">
                <label for="fileToUpload">Profile Picture:</label>
                <input type="file" id="fileToUpload" name="fileToUpload" required>
            </div>

            <button type="submit" class="btn btn-primary" name="btnSubmit">Submit</button>

            <a href="users.php">
                <button type="button" class="btn btn-danger">Cancel</button>
            </a>
        </form>
    </div>
</body>

</html>