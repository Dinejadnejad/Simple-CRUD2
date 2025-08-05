<?php
$servername = "localhost:8111";
$username = "root";
$password = ""; // sesuaikan jika ada password
$database = "phpdasar"; // nama database

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("koneksi gagal:" .mysqli_connect_error());
}
?>