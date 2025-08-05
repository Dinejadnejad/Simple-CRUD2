<?php
include 'koneksi.php';

$id = $_GET["id"];
$stmt = mysqli_prepare($conn, "SELECT * FROM mahasiswa2 WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan!");
}

if (isset($_POST["submit"])) {
    $nama = $_POST["nama"];
    $nrp = $_POST["nrp"];
    $email = $_POST["email"];
    $jurusan = $_POST["jurusan"];
    $gambarLama = $data["gambar"]; //Ambil gambar lama dari database
    //cek apakah ada file gambar baru yg diunggah
    if ($_FILES["gambar"]["error"] === 0) {
        $gambarBaru = $_FILES["gambar"]["name"];
        $tmpName = $_FILES["gambar"]["tmp_name"];
        $folderUpload = "uploads/";

        //hapus gambar lama jika ada
        if ($gambarLama && file_exists($folderUpload . $gambarLama)) {
            unlink($folderUpload . $gambarLama);
        }

        //pindahkan file ke folder uploads
        move_uploaded_file($tmpName, $folderUpload . $gambarBaru);
    } else {
        $gambarBaru = $gambarLama; // jika tidak ada gunakan yg lama
    }

    //update database
    $stmt = mysqli_prepare($conn, "UPDATE mahasiswa2 SET nama=?, nrp=?, email=?, jurusan=?, gambar=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $nama, $nrp, $email, $jurusan, $gambarBaru, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit();
    } else {
        echo "gagal mengupdate data!";
    }
     
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
</head>
<body>
    <h2>Edit Data Mahasiswa</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required><br>

        <label>NRP:</label><br>
        <input type="text" name="nrp" value="<?= htmlspecialchars($data['nrp']); ?>" required><br>

        <label>E-mail:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required><br>

        <label>jurusan:</label><br>
        <input type="text" name="jurusan" value="<?= htmlspecialchars($data['jurusan']); ?>" required><br>

        <label>Gambar:</label><br>
        <input type="file" name="gambar"><br>
        <?php if ($data['gambar']): ?>
            <img src="uploads/<?= htmlspecialchars($data['gambar']); ?>" width="100"><br>
        <?php endif; ?>

        <button type="submit" name="submit">Update</button>
    </form>
</body>
</html>