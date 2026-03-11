<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account - Info KRL</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Perbaikan khusus untuk menyelaraskan posisi mata di tengah */
        .password-container {
            position: relative;
            width: 100%;
            display: flex; /* Menggunakan flexbox untuk penyelarasan */
            align-items: center; /* Meratakan elemen secara vertikal */
            margin-bottom: 15px; /* Memberi jarak antar input */
        }

        .password-container input {
            width: 100%;
            padding-right: 45px !important; /* Ruang agar teks tidak tertutup ikon */
            margin-bottom: 0 !important; /* Menghapus margin bawah input agar container yang mengatur jarak */
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%; /* Letakkan di tengah tinggi container */
            transform: translateY(-50%); /* Tarik kembali ke atas 50% dari tinggi ikon sendiri */
            cursor: pointer;
            color: #888;
            z-index: 10;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1; /* Menghilangkan spasi font-awesome agar tidak miring */
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Create Account</h2>
            <p class="subtitle">Isi data diri (Email bersifat opsional)</p>
            
            <form action="register_process.php" method="POST">
                <input type="text" name="nik" placeholder="NIK (16 Digit)" required maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                <input type="text" name="full_name" placeholder="Nama Lengkap" required>
                <input type="email" name="email" placeholder="Email Address (Opsional)">
                <input type="text" name="phone" placeholder="Nomor Telepon" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                
                <div class="password-container">
                    <input type="password" name="password" id="reg_pass" placeholder="Password" required>
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('reg_pass', this)"></i>
                </div>
                
                <div class="password-container">
                    <input type="password" name="confirm_password" id="reg_confirm" placeholder="Konfirmasi Password" required>
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('reg_confirm', this)"></i>
                </div>
                
                <button type="submit" class="btn-primary" style="margin-top: 10px;">Sign up</button>
            </form>
            <p class="footer-text">Sudah punya akun? <a href="login_page.php">Sign in</a></p>
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