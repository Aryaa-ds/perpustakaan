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
<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kodebuku = $_POST['kode_buku'];
    $judulbuku = $_POST['judul_buku'];
    $np = $_POST['nama_pengarang'];
    $pn = $_POST['penerbit'];
    $id = $_POST['id_kategori'];
    $no = $_POST['no_urut'];

    // Simpan data buku
    $query = "INSERT INTO buku (kode_buku, judul_buku, nama_pengarang, penerbit, id_kategori, no_urut) 
              VALUES ('$kodebuku', '$judulbuku', '$np', '$pn', '$id', '$no')";
    mysqli_query($conn, $query);

    echo "<script>alert('Data telah ditambahkan'); window.location='dash.php';</script>";
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
    <div class="po">

        <div class="judul">
            <h3>tambah buku</h3>
        </div>
        <form method="POST"> 
            <div class="o">
                <div class="top">
                    <div class="in">
                        <label for="kodebuku">Kode buku</label>
                        <input type="text" name="kodebuku" id="kodebuku">
                    </div>
                    <div class="in">
                        <label for="judul buku">Judul buku</label>
                        <input type="text" name="judulbuku" id="judulbuku">
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="in">
                    <label for="">Nama Pengarang</label>
                    <input type="text" name="np" id="np">
                </div>
                <div class="in">
                    <label for="">penerbit</label>
                    <input type="text" name="pn" id="pn">
                    <button id='btn1' type="submit">Tambah data</button>
                </div>
            </div>
            <div class="p">
                <div class="in">
                    <label for="">id kategori</label>
                    <input type="text" name="id" id="idk">
                </div>
                <div class="in">
                    <label for="">no urut</label>
                    <input type="text" name="no" id="no">
                </div>
            </div>
        </form>
    </div>
    <div class="TOP">
    </div>
        <table class="table table-striped">
            <tr>
            <th>Kode buku</th>
            <th>Judul Buku</th>
            <th>Nama Pengarang</th>
            <th>Penerbit</th>
            <th>Id kategori</th>
            <th>no urut</th>
        </tr>
    
    
    
        <?php
        include "koneksi.php";
    
        $ambil_data = mysqli_query($conn, "select * from buku");
        while($tampil = mysqli_fetch_array($ambil_data)){
            echo"
            <tr>
                <td>$tampil[kode_buku]</td>
                <td>$tampil[judul_buku]</td>
                <td>$tampil[nama_pengarang]</td>
                <td>$tampil[penerbit]</td>
                <td>$tampil[id_kategori]</td>
                <td>$tampil[no_urut]</td>
            
            </tr>
    
            ";
        }
    
        ?>
    </table>
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