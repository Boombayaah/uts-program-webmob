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
    <title>Manajemen Akun Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin-page.css"> 

    <!-- Modal Box -->
    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        function delete_confirm() {
            if (confirm('Yakin menghapus akun ini?'))
                return true;
            else
                return false;
        }
    </script>

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "leader_sidebar.php"; ?>
            <div class="col-md-9 col-lg-10 main-content">
                <h4 class="mt-4">Manajemen Akun Admin</h4>
                <div class="wireframe-box">
                    <div class="row">
                        <div class="col-sm-6 col-md-12">
                            <div class="dashboard-card" style="background-color: #EFF6FF;">
                                <table class="table">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">NIK</th>
                                            <th scope="col">Profil</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Telephone</th>
                                            <th scope="col">Position</th>
                                            <th scope="col">Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php
                                            $sql = "";
                                            $sql = "SELECT * FROM users u JOIN roles r ON u.role_id = r.role_id WHERE u.role_id != 3 ORDER BY u.full_name";
                                            $result = mysqli_query($conn,  $sql);
                                            $i = 1;
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $nik = $row['nik'];
                                                    $full_name = $row['full_name'];
                                                    $email = $row['email'];
                                                    $telephone = $row['phone'];
                                                    $position = $row['role_name'];

                                                    $image_source = "../assets/images/profile/";
                                                    if(!empty($user_profile)) {
                                                        $image_source .= $user_profile;
                                                    } else {
                                                        $image_source .= 'default-avatar.jpg';
                                                    }
                                            ?>
                                            <tr>
                                                <td scope="row"><?php echo $nik; ?></td>
                                                <td class="text-center">
                                                    <img src="<?php echo $image_source; ?>" alt="Profile Image" class="img-fluid rounded-circle" width="40" height="40">
                                                </td>
                                                <td><?php echo $full_name; ?></td>
                                                <td><?php echo $email; ?></td>
                                                <td><?php echo $telephone; ?></td>
                                                <td class="text-center"><?php echo $position; ?></td>
                                                <td class="text-center">
                                                    <a href="edit_admin.php?nik=<?php echo $nik?>"><i class="fa-regular fa-pen-to-square text-black m-1"></i></a>
                                                    <a href="delete_admin.php?nik=<?php echo $nik?>" onclick="return delete_confirm();"><i class="fa-regular fa-trash-can text-black m-1"></i></a>
                                                </td>
                                            </tr>
                                            <?php 
                                                }
                                                mysqli_free_result($result);
                                            } 
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>