<?php
include 'koneksi.php';

if (isset($_POST["submit"])) {
    $nama = $_POST["nama"];
    $nrp = $_POST["nrp"];
    $email = $_POST["email"];
    $jurusan = $_POST["jurusan"];

    //pastikan folder uploads data
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    //cek apakah file yang diunggah adalah gambar
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        echo "File bukan gambar";
        exit();
    }

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $gambar = basename($_FILES["gambar"]["name"]);
        $query = "INSERT  INTO mahasiswa2 (nama, nrp, email, jurusan, gambar)
                  VALUES ('$nama', '$nrp', 'email', '$jurusan', '$gambar')";

        if (mysqli_query($conn, $query)) {
            echo "Data berhasil ditambahkan!";
            header("Location: index.php");
        } else {
            echo "Error:" . mysqli_error($conn);
        }
    } else {
        echo "Gagal mengunggah gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
</head>
<body>
    <h2>Tambah Data Mahasiswa</h2>
    <form action="tambah.php" method="post" enctype="multipart/form-data">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br>
        
        <label>NRP</label><br>
        <input type="text" name="nrp" required><br>

        <label>E-mail</label><br>
        <input type="email" name="email" required><br>

        <label>Jurusan</label><br>
        <input type="text" name="jurusan" required><br>

        <label>Upload gambar:</label><br>
        <input type="file" name="gambar" required><br>

        <button type="submit" name="submit">Tambah</button>
    </form>
</body>
</html>