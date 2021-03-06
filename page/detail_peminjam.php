<?php 
if(isset($_SESSION['login'])) {
  $id_peminjam = $_SESSION['login'];
}

// menampilkan data detail peminjam
@$detailPinjam = query("SELECT * FROM detail_peminjam
INNER JOIN buku ON detail_peminjam.id_buku = buku.id_buku
INNER JOIN pengarang ON buku.id_pengarang = pengarang.id_pengarang
INNER JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
WHERE id_peminjam = $id_peminjam AND status = 'pinjam' ORDER BY tgl_kembali ASC");

// menampilkan data peminjam
$peminjam = mysqli_query($conn, "SELECT * FROM peminjam WHERE id_peminjam = '$id_peminjam'");
$row = mysqli_fetch_assoc($peminjam);

if(isset($_POST['kembali'])){
  if(kembali($_POST) > 0){
    echo "<script>
    alert('Berhasil mengembalikan buku');
    document.location.href = '?page=dipinjam';
    </script>";
  } else {
    echo "<script>
    alert('Gagal mengembalikan buku');
    document.location.href = '?page=dipinjam';
    </script>";
  }
}

?>
    <!-- detail peminjam start -->
    <section class="detail-peminjam" id="detail-peminjam">
      <?php 
      // jika data detail kosong
      if(empty($detailPinjam)) {
        echo "<div class='detail-pinjam-kosong'>
        <h2>Anda belum meminjam buku</h2>
        </div>";
      } else {
        foreach($detailPinjam as $dp) :
      ?>
      <div class="detail-container">
        <div class="detail-wrapper">
          <div class="box">
            <div class="box-img">
              <img src="admin/img/<?= $dp['sampul']; ?>" alt="sampul" />
            </div>

            <div class="detail-box">
              <h3><?= $dp['judul'] ?></h3>
              <p>pengarang : <?= $dp['nama_pengarang'] ?></p>
              <p>penerbit : <?= $dp['nama_penerbit'] ?></p>
            </div>

            <div class="setatus-box">
              <div class="tgl-box">
                <div class="pinjam">
                  <p class="ket-tgl">tgl pinjam</p>
                  <p class="tgl"><?= $dp['tgl_pinjam'] ?></p>
                </div>
                <div class="kembali">
                  <p class="ket-tgl">tgl kembali</p>
                  <p class="tgl"><?= $dp['tgl_kembali'] ?></p>
                </div>
              </div>
              
              <h2><?php if($dp['status'] == 'pinjam') echo 'dipinjam'; ?></h2>
              <h3 style="text-align: center; margin: -.5rem 0 1rem 0; color: #f33a3a;">
              <?php 
                $denda = 1000;
                $dateline = $dp['tgl_kembali'];
                $tgl_sekarang = date('Y-m-d');
                $lambat = selisih($tgl_sekarang,$dateline);
                if($lambat > 0) {
                  $denda = $lambat * $denda;
                  echo "terlambat $lambat hari denda Rp. $denda";
                }
              ?>
              </h3>

              <form action="" method="POST">
                <input type="hidden" name="id_detail" value="<?= $dp['id_detail']; ?>">
                <input type="hidden" name="status" value="kembali">
                <input type="hidden" name="id_buku" value="<?= $dp['id_buku']; ?>">
                <input type="hidden" name="tgl_dikembalikan" value="<?= $tgl_sekarang; ?>">
                <div class="btn-kembali">
                  <button name="kembali" class="btn">kembali</button>
                  <a href="?page=perpanjang&id=<?= $dp['id_detail']; ?>&id_buku=<?= $dp['id_buku']; ?>&lambat=<?= $lambat; ?>&tgl_kembali=<?= $dp['tgl_kembali'] ?>" name="perpanjang" class="btn-border">perpanjang</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; } ?>
    </section>
    <!-- detail peminjam end -->