<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Info KRL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleloginregister.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS Tambahan agar harmoni dengan Bootstrap */
        .password-container {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .password-container input {
            padding-right: 45px !important;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            z-index: 10;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
    </style>
</head>

<body class="bg-light">
    <div class="auth-wrapper d-flex justify-content-center align-items-center vh-100 p-3">
        <div class="auth-card shadow-sm p-4 bg-white rounded-4 border" style="max-width: 450px; width: 100%;">
            <h2 class="fw-bold text-dark text-center mb-1">Create Account</h2>
            <p class="text-muted text-center small mb-4">Isi data diri (Email bersifat opsional)</p>

            <form action="register_process.php" method="POST" class="d-flex flex-column gap-2">
                <div class="mb-1">
                    <input type="text" name="nik" class="form-control" placeholder="NIK (16 Digit)" required maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div class="mb-1">
                    <input type="text" name="full_name" class="form-control" placeholder="Nama Lengkap" required>
                </div>

                <div class="mb-1">
                    <input type="email" name="email" class="form-control" placeholder="Email Address (Opsional)">
                </div>

                <div class="mb-1">
                    <input type="text" name="phone" class="form-control" placeholder="Nomor Telepon" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div class="mb-1">
                    <div class="password-container">
                        <input type="password" name="password" id="reg_pass" class="form-control" placeholder="Password" required>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('reg_pass', this)"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="password-container">
                        <input type="password" name="confirm_password" id="reg_confirm" class="form-control" placeholder="Konfirmasi Password" required>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('reg_confirm', this)"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm" style="background-color: #316eea; border: none;">Sign up</button>
            </form>

            <p class="text-center mt-4 mb-0 small text-muted">
                Sudah punya akun? <a href="login_page.php" class="text-decoration-none fw-bold" style="color: #316eea;">Sign in</a>
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