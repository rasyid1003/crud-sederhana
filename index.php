<?php
$server = "localhost";
$user = "root;
$pass = "";
$database = "mahasiswa";
$koneksi = new mysqli($server, $user, $pass, $database);

// Check the connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// If the 'simpan' button is clicked
if (isset($_POST['simpan'])) {
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $prodi = mysqli_real_escape_string($koneksi, $_POST['prodi']);

    $stmt = $koneksi->prepare("INSERT INTO kmhs (nim, nama, alamat, prodi) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nim, $nama, $alamat, $prodi);

    if ($stmt->execute()) {
        echo "<script>
            alert('Simpan data sukses!');
            window.location.href='index.php';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal!');
            window.location.href='index.php';
        </script>";
    }
    $stmt->close();
}

// Process edit/delete actions
if (isset($_GET['hal'])) {
    if ($_GET['hal'] == "edit") {
        $tampil = $koneksi->prepare("SELECT * FROM kmhs WHERE id_mhs = ?");
        $tampil->bind_param("i", $_GET['id']);
        $tampil->execute();
        $result = $tampil->get_result();

        if ($data = $result->fetch_assoc()) {
            $nim = $data['nim'];
            $nama = $data['nama'];
            $alamat = $data['alamat'];
            $prodi = $data['prodi'];
        }
        $tampil->close();
    } elseif ($_GET['hal'] == "hapus") {
        $hapus = $koneksi->prepare("DELETE FROM kmhs WHERE id_mhs = ?");
        $hapus->bind_param("i", $_GET['id']);
        if ($hapus->execute()) {
            echo "<script>
                alert('Hapus Data Sukses!');
                window.location.href='index.php';
            </script>";
        }
        $hapus->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- ... (rest of your HTML code) ... -->

</html>
