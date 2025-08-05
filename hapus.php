<?php
include 'koneksi.php';

$id = $GET["id"];

//hapus file gambar terlebih dahulu
$result = mysqli_query($conn, "SELECT gambar FROM mahasiswa2 WHERE id=$id");
$row = mysqli_fetch_assoc($result);
unlink("uploads/" . $row['gambar']);

//hapus data di database
mysqli_query($conn, "DELETE FROM mahasiswa2 WHERE id=$id");

header("Location: index.php");
?>