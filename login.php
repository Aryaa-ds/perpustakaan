<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Cek apakah username ada di database
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);

        // Cek apakah login sebagai admin
        if ($username == 'admin' && $password == 'adimn1234') {
            $_SESSION['username'] = $username;
            header("Location: dash.php");
            exit;
        }
        // Cek login user biasa
        elseif ($password == $data['password']) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Password salah!";
        }
    } else {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "Username tidak ditemukan!";
    }

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
<link rel="stylesheet" href="log.css">
</head>
<body>
    <form method="POST">
        <h2>Login</h2>
        <hr>
        <br>
        <label for="">username</label>
        <input type="text" name="username" required placeholder="Username"><br><br>
        <label for="">password</label>
        <input type="password" name="password" id="password" required placeholder="Password">
        <div class="pw">
                <label for="show_password">
                    <input type="checkbox" id="show_password">
                    Tampilkan password
                </label>
            </div>       
            <button type="submit">Login</button>
        <p>Belum punya akun? <a href='register.php'>Daftar di sini</a></p>
    </form>
<script>
    const inputPassword = document.getElementById("password");
    const showPassword = document.getElementById("show_password");

    showPassword.addEventListener("change", (e) => {
        if(e.target.checked) {
            inputPassword.setAttribute("type", "text");
        } else {
            inputPassword.setAttribute("type", "password");
        }
    });
</script>
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if (isset($_SESSION['status']) && isset($_SESSION['message'])) {
    echo "<script>
        Swal.fire({
            icon: '{$_SESSION['status']}',
            title: '{$_SESSION['message']}'
        });
    </script>";
    unset($_SESSION['status']);
    unset($_SESSION['message']);
}
?>
</body>
</html>