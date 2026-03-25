<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commuter | Login Akun</title>
    <link rel="stylesheet" href="../assets/css/styleloginregister.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
        /* Container Utama Pilihan */
        .method-selector {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin: 20px 0;
            transition: all 0.5s ease-in-out;
        }

        /* Styling Tombol Lingkaran/Oval */
        .btn-method {
            width: 100%;
            max-width: 200px;
            padding: 12px;
            border: 2px solid #007bff;
            background: transparent;
            color: #007bff;
            border-radius: 30px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            opacity: 1;
            transform: scale(1);
        }

        .btn-method:hover {
            background: rgba(0, 123, 255, 0.05);
            transform: translateY(-2px);
        }

        /* Animasi saat terpilih */
        .btn-method.selected {
            background: #007bff;
            color: white;
            max-width: 100%;
            border-radius: 8px;
            transform: scale(1.02);
        }

        /* Animasi menghilang untuk yang tidak dipilih */
        .method-selector.active .btn-method:not(.selected) {
            opacity: 0;
            transform: scale(0.8);
            pointer-events: none;
            margin: -20px 0;
        }

        /* Area Form */
        #login-form-area {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: all 0.5s ease-in-out;
        }

        #login-form-area.show {
            max-height: 500px;
            opacity: 1;
            margin-top: 10px;
        }

        .btn-reset {
            background: none;
            border: none;
            color: #007bff;
            font-size: 12px;
            text-decoration: underline;
            cursor: pointer;
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* --- MODIFIKASI POSISI MATA PASSWORD --- */
        .password-container {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .password-container input {
            width: 100%;
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

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2 id="login-title">Metode Login</h2>

            <button type="button" id="reset-btn" class="btn-reset" style="display:none;" onclick="resetSelector()">← Ganti Metode</button>

            <div class="method-selector" id="selector">
                <button type="button" class="btn-method" id="m-nik" onclick="selectMethod('nik')">NIK</button>
                <button type="button" class="btn-method" id="m-email" onclick="selectMethod('email')">Email</button>
                <button type="button" class="btn-method" id="m-phone" onclick="selectMethod('phone')">No. Telp</button>
            </div>

            <div id="login-form-area">
                <form action="login.php" method="POST">
                    <label id="input-label" style="display:block; text-align:left; font-size:12px; margin-bottom:5px; font-weight:bold;"></label>
                    <input type="text" name="identifier" id="main-input" required>

                    <div style="margin-top: 15px; text-align: left;">
                        <label style="display:block; font-size:12px; margin-bottom:5px; font-weight:bold;">Password:</label>
                        <div class="password-container">
                            <input type="password" name="password" id="login_pass" placeholder="Masukkan Password" required>
                            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('login_pass', this)"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top: 25px;">Sign in</button>
                </form>
            </div>

            <p class="footer-text">Belum punya akun? <a href="register.php">Sign up</a></p>
        </div>
    </div>

    <script>
        let selectedType = '';

        function selectMethod(type) {
            selectedType = type;
            const selector = document.getElementById('selector');
            const formArea = document.getElementById('login-form-area');
            const input = document.getElementById('main-input');
            const label = document.getElementById('input-label');
            const resetBtn = document.getElementById('reset-btn');
            const title = document.getElementById('login-title');

            selector.classList.add('active');
            document.getElementById('m-' + type).classList.add('selected');

            title.innerText = "Login";
            resetBtn.style.display = "inline-block";

            if (type === 'nik') {
                label.innerText = "Masukkan 16 Digit NIK:";
                input.placeholder = "Contoh: 3201xxxxxxxxxxxx";
                input.type = "text";
            } else if (type === 'email') {
                label.innerText = "Masukkan Alamat Email:";
                input.placeholder = "contoh@email.com";
                input.type = "email";
            } else if (type === 'phone') {
                label.innerText = "Masukkan Nomor Telepon:";
                input.placeholder = "0812xxxxxxxx";
                input.type = "text";
            }

            setTimeout(() => {
                formArea.classList.add('show');
                input.focus();
            }, 400);

            input.oninput = function() {
                if (selectedType === 'nik') {
                    this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
                } else if (selectedType === 'phone') {
                    this.value = this.value.replace(/[^0-9]/g, '');
                }
            };
        }

        function resetSelector() {
            const selector = document.getElementById('selector');
            const formArea = document.getElementById('login-form-area');
            const resetBtn = document.getElementById('reset-btn');
            const title = document.getElementById('login-title');

            // 1. Sembunyikan form area dengan animasi
            formArea.classList.remove('show');

            // 2. Gunakan sedikit timeout agar transisi penutupan form terasa sinkron dengan kemunculan tombol
            setTimeout(() => {
                selector.classList.remove('active');
                title.innerText = "Login Method";
                resetBtn.style.display = "none";

                document.querySelectorAll('.btn-method').forEach(btn => {
                    btn.classList.remove('selected');
                });
            }, 200);
        }

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