<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #1E3A8A;">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
      <span style="color: #F59E0B; font-size: 1.5rem;" class="me-2">
        <i class="bi bi-train-front-fill"></i>
      </span> 
      CommuterLink
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navLostFound">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navLostFound">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="dashboard.php">Beranda</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="form-lapor.php">Lapor Kehilangan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="status-klaim.php">Status Barang</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-info" href="#" id="menuPetugas" role="button" data-bs-toggle="dropdown">
            Panel Petugas
          </a>
          <ul class="dropdown-menu shadow border-0">
            <li><a class="dropdown-item" href="input-temuan.php">Input Barang Temuan</a></li>
            <li><a class="dropdown-item" href="pencocokan.php">Pencocokan Data</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="approval-atasan.php">Persetujuan (Atasan)</a></li>
          </ul>
        </li>
      </ul>

      <div class="d-flex gap-2">
        <a href="login.php" class="btn btn-outline-light btn-sm px-4">Login</a>
        <a href="register.php" class="btn btn-sm px-4" style="background-color: #F59E0B; color: #1E3A8A; font-weight: 600;">Register</a>
        
        </div>
    </div>
  </div>
</nav>