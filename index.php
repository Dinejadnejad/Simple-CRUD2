<?php
include 'koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM mahasiswa2");
?>

<!DDOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa</title>  
    <style>
        h2{
            color: black;
        }

        a{
            color: black;
            text-decoration: none;
        }

        a:hover{
            color: blue;
        }
    </style> 
</head>
<body>
    <h2>Data Mahasiswa</h2>
    <a href="tambah.php">+Tambah Data Mahasiswa</a>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>NO</th>
            <th>Nama</th>
            <th>NRP</th>
            <th>E-mail</th>
            <th>Jurusan</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row["nama"]; ?></td>
                <td><?= $row["nrp"]; ?></td>
                <td><?= $row["email"]; ?></td>
                <td><?= $row["jurusan"]; ?></td>
                <td><img src="uploads/<?= $row['gambar']; ?>" width="70"></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>">Edit</a> |
                    <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>