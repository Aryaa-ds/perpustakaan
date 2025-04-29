<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Cek apakah username sudah ada
    $cek_user = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek_user) > 0) {
    
        echo "<script>alert('Username sudah digunakan! Silakan pilih yang lain.');</script>";
    } elseif(strlen($password) < 8) {
        echo"<script>alert('password minimal 8 karakter'!);</script>";
    }else{
            // Kalau belum ada, simpan user baru
            $query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
            mysqli_query($conn, $query);
    
            echo "<script>alert('Registrasi berhasil!'); window.location='login.php';</script>";
        }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="log.css">
    </head>
    <body>
        <form method="POST">
            <h2>Register</h2>
            <hr>
            <br>
            <div class="user-email">
                <div class="user">
                    <label for="username">Username</label>
                    <input type="text" name="username" required placeholder="Username"><br><br>
                </div>
                <div class="email">
                    <label for="email">Email</label>
                    <input type="text" name="email" required placeholder="contoh@gmail.com"><br><br>
                </div>
            </div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required placeholder="Password" minlength="8">
            <label for="password">Konfirmasi Password</label>
            <input type="password" name="password" id="password1" required placeholder="Konfirmasi password" minlength="8">
                <div class="pw">
                    <label for="show_password">
                        <input type="checkbox" id="show_password">
                        Tampilkan password
                    </label>
                </div>
            <button type="submit">Register</button>
            <p>Sudah punya akun? <a href='login.php'>Login</a></p>
        </form>

    <script>
    const inputPassword = document.getElementById("password");
    const showPassword = document.getElementById("show_password");
    const konfirpw = document.getElementById("password1");

    showPassword.addEventListener("change", (e) => {
        if(e.target.checked) {
            inputPassword.setAttribute("type", "text");
            konfirpw.setAttribute("type", "text");
        } else {
            inputPassword.setAttribute("type", "password");
            konfirpw.setAttribute("type", "password");
        }
    });
    </script>
</body>
</html>