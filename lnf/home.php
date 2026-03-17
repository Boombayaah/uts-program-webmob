<?php
session_start();
$active = "home";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CommuterLink</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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

        .navbar .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }

        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
        }

        .navbar .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            display: block;
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

        .hero-section {
            position: relative;
            background: url("assets/images/6588183a4af899491f095fb1b8b1a46c.png");
            background-size: cover;
            background-position: center;
            color: white;
        }

        /* overlay agar text terbaca */
        .hero-section::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0.3;
            background: linear-gradient(rgba(30, 58, 138, 0.75),
                    rgba(30, 58, 138, 0.65));
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        .breathing {
            animation: breathing 3s ease-in-out infinite;
        }

        @keyframes breathing {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <?php include "navbarr.php"; ?>
    <!-- HERO -->
    <section class="hero-section py-5 text-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="fw-bold mb-4">
                        Sistem Pelaporan Barang Hilang KRL
                    </h1>
                    <p class="lead mb-4 text-white">
                        CommuterLink membantu penumpang melaporkan kehilangan
                        dan menemukan kembali barang tertinggal secara cepat,
                        transparan, dan terintegrasi dengan sistem stasiun.
                    </p>
                    <a href="index.php" class="btn btn-lg px-4"
                        style="background:#F59E0B;color:#1E3A8A;font-weight:600;">
                        Laporkan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG KAMI -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Tentang Kami</h2>
                <p class="text-muted">
                    Platform digital untuk membantu proses pencarian barang
                    hilang penumpang KRL secara efisien.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-search fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold">Pelaporan Mudah</h5>
                        <p class="text-muted small">
                            Penumpang dapat melaporkan barang hilang dengan cepat
                            melalui sistem pelaporan online.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-link-45deg fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold">Sistem Matching</h5>
                        <p class="text-muted small">
                            Barang temuan dari petugas dapat dicocokkan dengan
                            laporan kehilangan menggunakan sistem pencocokan.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="bi bi-shield-check fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold">Transparan</h5>
                        <p class="text-muted small">
                            Semua proses pelaporan dan pencocokan barang dilakukan
                            secara transparan dan dapat dipantau pengguna.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kantor Pusat -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-2">
                <h2 class="fw-bold">Kantor Pusat</h2>
                <p class="text-muted">Lt. 1 Pintu Utara gambir, Jl. Medan Merdeka Tim. No.17 2, RT.5/RW.2, Gambir, Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31733.258130068447!2d106.7924839743164!3d-6.176615200000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f432b173073b%3A0xc46c57b0bc75ea34!2sPT.%20Kereta%20Api%20Pariwisata!5e0!3m2!1sid!2sid!4v1773681763052!5m2!1sid!2sid" width="1200" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Pertanyaan Umum</h2>
                <p class="text-muted">Informasi yang sering ditanyakan pengguna</p>
            </div>

            <div class="accordion" id="faq">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#f1">
                            Bagaimana cara melaporkan barang hilang?
                        </button>
                    </h2>
                    <div id="f1" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            Pengguna dapat mengisi formulir pelaporan barang hilang pada menu
                            <strong>Pusat Pelaporan</strong>.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f2">
                            Bagaimana jika barang saya ditemukan?
                        </button>
                    </h2>
                    <div id="f2" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            Sistem akan mencocokkan laporan kehilangan dengan data barang
                            temuan dari petugas stasiun.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f3">
                            Bagaimana cara klaim barang?
                        </button>
                    </h2>
                    <div id="f3" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            Jika barang cocok dengan laporan Anda, petugas akan menghubungi
                            untuk proses verifikasi dan pengambilan barang.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>