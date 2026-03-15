<?php
session_start();
if (!isset($_SESSION['email'])) { header("Location: ../auth/login_page.php"); exit(); }
include '../config/database.php';

$email_session = $_SESSION['email'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '$email_session'"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $new_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    // Membersihkan input dari karakter selain angka secara otomatis di server
    $new_phone = preg_replace('/[^0-9]/', '', $new_phone);

    $sql = "UPDATE users SET full_name='$new_name', phone='$new_phone' WHERE email='$email_session'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['full_name'] = $new_name;
        echo "<script>alert('Perubahan berhasil disimpan!'); window.location='profile.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Settings - Info KRL</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="../index.PHP" class="btn-home">Home</a>
            <h2>Edit Settings</h2>
            
            <form method="POST">
                <label style="display:block; text-align:left; font-size:12px; margin-bottom:5px;">Nama Lengkap</label>
                <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>
                
                <label style="display:block; text-align:left; font-size:12px; margin-bottom:5px; margin-top:10px;">Nomor Telepon</label>
                <input type="text" name="phone" 
                       value="<?php echo $user['phone']; ?>" 
                       inputmode="numeric" 
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                       required>

                <p style="font-size: 12px; color: gray; margin-top:15px;">Email dan NIK tidak dapat diubah.</p>
                <button type="submit" class="btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>