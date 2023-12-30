<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "mahasiswa";
$koneksi = mysqli_connect($server, $user, $pass, $database);
// akhir koneksi
// check the connection
if (!$koneksi) {
  die("Connection failed: " . mysqli_connect_error());
}

// jika simpan di klik
if (isset($_POST['simpan'])) {
    $simpan = mysqli_query($koneksi, "INSERT INTO kmhs (nim, nama, alamat, prodi) VALUES ('$_POST[nim]', '$_POST[nama]', '$_POST[alamat]', '$_POST[prodi]')");

    if($simpan) {
        echo "<script>
        alert('Simpan data sukses!');
        document.location='index.php';
        </script>";
    } else {
        echo "<script>
        alert('Simpan data gagal!');
        document.location='index.php';
        </script>";
    }
}

//Pengujian jika tombol Edit / Hapus di klik
if(isset($_GET['hal'])) {
    //Pengujian jika edit Data
    if($_GET['hal'] == "edit") {
        //Tampilkan Data yang akan diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM kmhs WHERE id_mhs = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);

        if($data) {
            //Jika data ditemukan, maka data ditampung ke dalam variabel
            $nim = $data['nim'];
            $nama = $data['nama'];
            $alamat = $data['alamat'];
            $prodi = $data['prodi'];
        }
    } else if ($_GET['hal'] == "hapus") {
        //Persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM kmhs WHERE id_mhs = '$_GET[id]' ");
        if($hapus){
            echo "<script>
                    alert('Hapus Data Sukses!');
                    document.location='index.php';
                 </script>";
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
    <h1 class="text-center">CRUD</h1>
    <h2 class="text-center">pembuatan crud</h2>
    <div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Mahasiswa
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Nim</label>
	    		<input type="text" name="nim" value="<?=@$nim?>" class="form-control" placeholder="Input Nim anda disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Nama</label>
	    		<input type="text" name="nama" value="<?=@$nama?>" class="form-control" placeholder="Input Nama anda disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Alamat</label>
	    		<textarea class="form-control" name="alamat"  placeholder="Input Alamat anda disini!"><?=@$alamat?></textarea>
	    	</div>
	    	<div class="form-group">
	    		<label>Program Studi</label>
	    		<select class="form-control" name="prodi">
	    			<option value="<?=@$vprodi?>"><?=@$vprodi?></option>
	    			<option value="D3-MI">D3-MI</option>
	    			<option value="S1-SI">S1-SI</option>
	    			<option value="S1-TI">S1-TI</option>
	    		</select>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="simpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="reset">Kosongkan</button>

	    </form>
  </div>
</div>

<!-- table -->


<div class="card nt-3">
  <div class="card-header bg-success text-white">
    Table Mahasiswa
  </div>
  <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No</th>
                <th>Nim</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Prodi</th>
                <th>Aksi</th>
            </tr>
            <?php 
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * from kmhs order by id_mhs desc");
            while($data = mysqli_fetch_array($tampil)):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['nim'] ?></td>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['alamat'] ?></td>
                <td><?= $data['prodi'] ?></td>
                <td>
                    <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning">Edit</a>
                    <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
  </div>
</div>
<footer>Copyrigth By Faris Rasyid</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
