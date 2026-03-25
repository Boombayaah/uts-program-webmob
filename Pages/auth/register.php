<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commuter | Register Akun</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/styleloginregister.css">


    <link rel="apple-touch-icon" sizes="57x57" href="../assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <style>
        body {
            background: #f8f9fa;
        }

        .auth-card {
            max-width: 450px;
            width: 100%;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #316eea;
        }

        .btn-primary {
            background-color: #316eea;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2557c7;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100 p-3">
        <div class="auth-card bg-white p-4 rounded-4 shadow-sm border">

            <h3 class="fw-bold text-center mb-1">Membuat Akun</h3>
            <p class="text-muted text-center small mb-4">Lengkapi data diri Anda</p>

            <form action="register_process.php" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                <!-- NIK -->
                <div>
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control"
                        placeholder="16 digit NIK"
                        maxlength="16"
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <!-- Nama -->
                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control"
                        placeholder="Nama lengkap" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="form-label">Email (opsional)</label>
                    <input type="email" name="email" class="form-control"
                        placeholder="example@email.com">
                </div>

                <!-- Phone -->
                <div>
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="phone" class="form-control"
                        placeholder="08xxxxxxxxxx"
                        maxlength="16"
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <!-- Upload -->
                <div>
                    <label class="form-label">Profile Picture (opsional)</label>
                    <input type="file" name="fileToUpload" class="form-control" required>
                </div>

                <!-- Password -->
                <div>
                    <label class="form-label">Password</label>
                    <div class="password-container">
                        <input type="password" name="password" id="reg_pass"
                            class="form-control" placeholder="Masukkan password" required>
                        <i class="fa-solid fa-eye toggle-password"
                            onclick="togglePassword('reg_pass', this)"></i>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="form-label">Confirm Password</label>
                    <div class="password-container">
                        <input type="password" name="confirm_password" id="reg_confirm"
                            class="form-control" placeholder="Ulangi password" required>
                        <i class="fa-solid fa-eye toggle-password"
                            onclick="togglePassword('reg_confirm', this)"></i>
                    </div>
                </div>

                <!-- Button -->
                <button type="submit" class="btn btn-primary py-2 fw-bold">
                    Sign Up
                </button>
            </form>

            <p class="text-center mt-4 small text-muted">
                Sudah punya akun?
                <a href="login_page.php" class="fw-bold text-decoration-none" style="color:#316eea;">
                    Sign in
                </a>
            </p>

        </div>
    </div>

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                el.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                el.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>

</body>

</html>