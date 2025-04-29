<?php
include 'koneksi.php';

$keyword = isset($_GET['search']) ? $_GET['search'] : '';
?>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
        
<title>Daftar Buku</title>


    <link rel="stylesheet" href="ty.css?v=<?=filemtime('ty.css'); ?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

</head>
<body>
    <div class="all">

        <nav class="navbar bg1-body-tertiary" ><br>
        <div class="container-fluid">
            <h4>Selamat datang, <?php echo $_SESSION['username']; ?>!</h4>
            <a id="logout" href="login.php" class="navbar-brand">Logout</a>
        </div>
    </nav>
    <div class="TOP">
        
        <div class="search">
            <h2 id='p'>Daftar Buku</h2>
            <div class="search-box">
                <form method="GET">
                    <input type="text" name="search" placeholder="Cari judul buku..." value="<?php echo htmlspecialchars($keyword); ?>">
                    <button type="submit">Cari</button>
                </form>
            </div>
        </div>
        
        <?php
    if (!empty($keyword)) {
        echo "<h2>Hasil pencarian: " . htmlspecialchars($keyword) . "</h2>";
        $searchQuery = "SELECT * FROM buku WHERE judul_buku LIKE '%" . $conn->real_escape_string($keyword) . "%'";
        $searchResult = $conn->query($searchQuery);
        
        if ($searchResult->num_rows > 0) {
            echo "<div class='scroll-container'>";
            while ($row = $searchResult->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<img src='images/buku.jpg' alt='Gambar Buku'>";
                echo "<hr>";
                echo htmlspecialchars($row["judul_buku"]) . "<br>";
                echo "<strong>Penulis:</strong> " . htmlspecialchars($row["nama_pengarang"]) . "<br>";
                echo "<strong>Penerbit:</strong> " . htmlspecialchars($row["penerbit"]);
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "Buku tidak ditemukan.";
        }
    } else {
        // Tampilkan semua buku per kategori kalau tidak mencari
        $kategoriQuery = "SELECT DISTINCT id_kategori FROM buku";
        $kategoriResult = $conn->query($kategoriQuery);
        
        while ($kategori = $kategoriResult->fetch_assoc()) {
            $namaKategori = htmlspecialchars($kategori["id_kategori"]);
            echo "<h3>$namaKategori</h3>";
            echo "<hr>";
            echo "<div class='scroll-container'>";
            
            $bukuQuery = "SELECT * FROM buku WHERE id_kategori='" . $conn->real_escape_string($kategori["id_kategori"]) . "'";
            $bukuResult = $conn->query($bukuQuery);
            
            while ($row = $bukuResult->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<img src='images/buku.jpg' alt='Gambar Buku'>";
                echo "<hr>";
                echo htmlspecialchars($row["judul_buku"]) . "<br>";
                echo "<strong>Penulis:</strong> " . htmlspecialchars($row["nama_pengarang"]) . "<br>";
                echo "<strong>Penerbit:</strong> " . htmlspecialchars($row["penerbit"]);
                echo "</div>";
            }
            
            echo "</div>"; // Tutup scroll-container
        }
    }
    
    ?>
</div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const logout = document.getElementById("logout");

  logout.onclick = function(e) {
    e.preventDefault(); // mencegah aksi default (kalau pakai <a> atau <form>)
    Swal.fire({
      title: 'Yakin mau logout?',
      text: "Kamu akan keluar dari sesi ini.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, logout!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'logout.php'; // arahkan ke file logout
      }
    });
  };
</script>
</html>