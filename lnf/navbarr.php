<?php
$logged_in = isset($_SESSION['user_id']);
include 'config/connection.php';
if ($_SESSION) {
  $uid = $_SESSION['user_id'];
  $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$uid'"));
}
?>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #1E3A8A;">
  <div class="container-fluid px-5">
    <a class="navbar-brand fw-bold d-flex align-items-center" style="color: #F59E0B;" href="home.php">
      <i class="fas fa-train me-2"></i>
      CommuterLink
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navLostFound">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navLostFound">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php if ($active == 'home') echo 'active'; ?>" href="home.php">Beranda</a>
        </li>

        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle <?php if ($active == 'cs') echo 'active'; ?>" id="cust" role="button">
            Customer Service
          </a>

          <ul class="dropdown-menu">
            <li><a href="index.php" class="dropdown-item">Pusat Pelaporan</a></li>
          </ul>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto align-items-center gap-2">
        <?php if ($logged_in): ?>
          <li class="nav-item">
            <a href="user/profile.php" class="btn btn-outline-light btn-sm px-4">
              <?php $image_source = "assets/images/profile/";
              if (!empty($user['profile_image'])) {
                $image_source .= "uploads/";
                $image_source .= $user['profile_image'];
              } else {
                $image_source .= 'default-avatar.jpg';
              }
              ?>
              <img src="<?php echo $image_source; ?>" alt="Profile Image" class="img-fluid rounded-circle me-2" width="20" height="20">
              <?php echo $_SESSION['full_name']; ?></a>
          </li>
          <li class="nav-item">
            <a href="auth/logout.php" class="btn btn-sm px-4"
              style="background-color:#F59E0B;color:#1E3A8A;font-weight:600;">
              Logout
            </a>
          </li>

        <?php else: ?>
          <li class="nav-item">
            <a href="auth/login_page.php" class="btn btn-outline-light btn-sm px-4">Login</a>
          </li>
          <li class="nav-item">
            <a href="auth/register.php" class="btn btn-sm px-4"
              style="background-color:#F59E0B;color:#1E3A8A;font-weight:600;">
              Register
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>