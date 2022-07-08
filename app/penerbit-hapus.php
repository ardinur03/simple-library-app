<?php

include './config/koneksi-db.php';

if (isset($_GET['id'])) {
    $id_penerbit = $_GET['id'];

    if (!empty($id_penerbit)) {
        $sql = "DELETE FROM penerbit WHERE id_penerbit = '{$id_penerbit}';";
        $query = mysqli_query($db_conn, $sql);
        if (!$query) {
            echo "<script>alert('Data sedang berelasi dengan tabel lain');</script>";
        }
    } else {
        echo "<script>alert('ID penerbit kosong!');</script>";
    }
} else {
    echo "<script>alert('ID penerbit tidak didefinisikan!');</script>";
}

echo "<script>alert('Data berhasil di hapus');</script>";
echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
