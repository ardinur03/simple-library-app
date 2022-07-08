<?php

if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    if (!empty($id_buku)) {
        $sql = "DELETE FROM buku WHERE id_buku = '{$id_buku}';";
        $query = mysqli_query($db_conn, $sql);
        if (!$query) {
            echo "<script>alert('Data sedang berelasi dengan tabel lain');</script>";
        } else {
            echo "<script>alert('Data berhasil di hapus');</script>";
        }
    } else {
        echo "<script>alert('ID Buku kosong!');</script>";
    }
} else {
    echo "<script>alert('ID buku tidak didefinisikan!');</script>";
}

echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
