<?php
    // Mendapatkan nama file saat ini
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin-page.css"> 

</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="col-md-3 col-lg-2 sidebar p-0">
        <div class="p-4">
            <h3 class="sidebar-title mb-4">
                <i class="fas fa-train text-primary me-2"></i>
                <span>CommuterLink</span>
            </h3>

            <ul class="nav flex-column" id="sidebar-nav">
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($currentPage == 'dashboardleader.php') echo 'active'; ?>" href="dashboardleader.php">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($currentPage == 'verification.php') echo 'active'; ?>" href="verification.php">
                        <i class="fas fa-handshake me-2"></i> Verifikasi Barang
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($currentPage == 'adminmanagement.php') echo 'active'; ?>" href="adminmanagement.php">
                        <i class="fa-solid fa-people-group me-2"></i> Manajemen Admin
                    </a>
                </li>

                <?php if ($logged_in): ?>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="../user/profile.php">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link" href="../auth/logout.php">
                            <i class="fas fa-sign-out me-2"></i> Logout
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
