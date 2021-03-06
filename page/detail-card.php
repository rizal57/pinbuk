<?php 
$id_buku = $_GET['id_buku'];
$detailBuku = query("SELECT * FROM buku
INNER JOIN pengarang ON buku.id_pengarang = pengarang.id_pengarang
INNER JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
WHERE id_buku = $id_buku")[0];

$tgl_pinjam = date('d-m-Y');
$tujuh_hari = date('d-m-Y', strtotime('+7 days'));
$kembali = date('d-m-Y', strtotime('+14 days'));
// ketika tombol pinjam di klik
if(isset($_POST['pinjam'])) {
    if(isset($_SESSION['login'])) {
    if(pinjam($_POST) > 0) {
        echo "<script>
        alert('Buku berhasil dipinjam');
        document.location.href = '?page=dipinjam';
        </script>";
    } else {
      echo "<script>
      alert('Buku gagal dipinjam');
      document.location.href = '';
      </script>";
    }
  } else {
    echo "<script>
            alert('Anda harus login terlebih dahulu');
            document.location.href = 'login.php';
          </script>
    ";
  }
  }


?>
    <!-- detail start -->
    <section class="detailBuku" id="detailBuku">
      <form action="" method="POST">
        <div class="detail-container">
          <div class="detail-wrapper">
            <div class="detail-img">
              <img src="admin/img/<?= $detailBuku['sampul']; ?>" alt="sampul" />
            </div>
            <div class="detail-info">
              <h1><?= $detailBuku['judul']; ?></h1>
              <p>pengarang : <?= $detailBuku['nama_pengarang']; ?></p>
              <p>penerbit : <?= $detailBuku['nama_penerbit']; ?></p>
              <p>tahun terbit : <?= $detailBuku['tahun_terbit']; ?></p>
              <p>ISBN : <?= $detailBuku['isbn']; ?></p>
              <p>sinopsis : <br>
                <?= $detailBuku['sinopsis'] ?>
              </p>
            </div>
            <div class="detail-pinjam">
              <div class="tgl">
                <div class="tgl-pinjam">
                  <p>tanggal pinjam</p>
                  <p><span><?= $tgl_pinjam ?></span></p>
                </div>
                <div class="tgl-kembali">
                  <p>tanggal kembali</p>
                  <p><span><?= $tujuh_hari ?></span></p>
                </div>
                <div class="jumlah">
                  <p>jumlah</p>
                  <p><span><?= $detailBuku['jumlah']; ?></span></p>
                </div>
              </div>
              <input type="hidden" name="id_peminjam" value="<?= @$_SESSION['login']; ?>">
              <input type="hidden" name="id_buku" value="<?= $id_buku; ?>">
              <input type="hidden" name="tgl_pinjam" value="<?= $tgl_pinjam; ?>">
              <input type="hidden" name="tgl_kembali" value="<?= $tujuh_hari; ?>">
              <input type="hidden" name="status" value="pinjam">
              <button name="pinjam" class="btn">pinjam</button>
            </div>
          </div>
        </div>
      </form>
    </section>
    <!-- detail end -->

    <!-- books start -->
    <section class="books" id="books">
      <div class="heading">
        <span>Books</span>
      </div>
      <!-- slider -->
      <div class="slider">
        <?php foreach($buku as $sb) : ?>
        <div>
          <!-- box slider -->
          <div class="box">
            <div class="slide-img">
              <img src="img/dasar.jpg" alt="Books" />
            </div>
            <!-- detail box -->
            <div class="detail-box">
              <!-- type -->
              <div class="type">
                <h3><?= $sb['judul']; ?></h3>
                <p>pengarang : <?= $sb['nama_pengarang']; ?></p>
                <p>pengarang : <?= $sb['nama_penerbit']; ?></p>
              </div>
              <!-- pinjam -->
              <div class="btnCard">
              <a class="btn-card" href='?page=home&aksi=detail&id_buku=<?= $sb['id_buku']; ?>'><i class="uil uil-message"></i></a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
    <!-- books end -->