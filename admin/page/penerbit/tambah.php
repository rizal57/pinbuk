<?php 
require_once '../functions/functions.php';

// tombol simpan di klik
if(isset($_POST['simpan'])) {
  if(tambahPenerbit($_POST) > 0) {
      echo "<script>
      alert('Penerbit berhasil ditambahkan');
      document.location.href = '?page=penerbit';
      </script>";
  } else {
    echo "<script>
    alert('Penerbit gagal ditambahkan');
    document.location.href = '';
    </script>";
  }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Penerbit</h1>
<a href="?page=penerbit" class="btn btn-primary mb-3">Kembali</a>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Data Penerbit</h6>
  </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <form method="post" role="form" enctype="multipart/form-data">

            <div class="form-group">
              <label>Nama Penerbit</label>
              <input type="text" class="form-control" name="nama_penerbit" />
            </div>
            
            <div class="form-group">
              <label>No Hp / Telp</label>
              <input type="text" class="form-control" name="tlp" />
            </div>

            <div class="form-group">
              <label for="exampleFormControlTextarea1">Alamat</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="alamat"></textarea>
            </div>

            <div class="form-group">
              <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>