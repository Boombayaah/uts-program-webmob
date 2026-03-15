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

    <style>
        :root {
            --primary-color: #1E3A8A;
            --secondary-color: #3B82F6;
            --accent-color: #F59E0B;
            --light-bg: #F8FAFC;
            --dark-text: #1F2937;
            --gray-text: #6B7280;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #3B82F6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            background-color: var(--light-bg);
            line-height: 1.6;
        }

        .color-swatch {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            display: inline-block;
            margin-right: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .component-card {
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 30px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .component-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .wireframe-box {
            border: 2px dashed #D1D5DB;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #F9FAFB;
            min-height: 200px;
        }

        .nav-flow {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }

        .nav-step {
            background-color: var(--secondary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            position: relative;
        }

        .nav-step:after {
            content: "→";
            position: absolute;
            right: -15px;
            color: var(--gray-text);
        }

        .nav-step:last-child:after {
            content: "";
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600;
            color: var(--primary-color);
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #1E40AF;
            border-color: #1E40AF;
        }

        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }

        .btn-accent:hover {
            background-color: #D97706;
            border-color: #D97706;
        }

        .sidebar {
            background-color: white;
            border-right: 1px solid #E5E7EB;
            min-height: 100vh;
        }

        /* .sidebar .nav-link.active {
            background-color: #3B82F6;
            color: white;
            border-radius: 8px;
        } */

        .main-content {
            padding: 30px;
        }

        .dashboard-card {
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table-custom {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table-custom thead {
            background-color: var(--primary-color);
            color: white;
        }

        .search-filter {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .sidebar .nav-link {
            color: black;

        }

        .sidebar .nav-link:hover {
            color: #2563eb;
        }

        .sidebar .nav-link.active {
            color: #2563eb;
        }

        #sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #000;
            font-size: 16px;
            padding: 10px 12px;
            border-radius: 6px;
        }

        #sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
        }

        #sidebar-nav .nav-link:hover {
            background-color: #f2f2f2;
        }

        #sidebar-nav .nav-link.active {
            color: #2f6fed;
            font-weight: 600;
        }

        .sidebar-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: #2c4c8c;
        }

        .sidebar-title i {
            font-size: 26px;
            color: #2f6fed;
        }

        .sidebar-title span {
            font-size: 22px;
        }
    </style>
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
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link" href="verification.php">
                        <i class="fas fa-handshake me-2"></i> Verifikasi Barang
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link" href="adminmanagement.php">
                        <i class="fa-solid fa-people-group me-2"></i> Manajemen Admin
                    </a>
                </li>

                <?php if ($logged_in): ?>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="user/profile.php">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link" href="auth/logout.php">
                            <i class="fas fa-sign-out me-2"></i> Logout
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
