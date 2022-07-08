<?php

if (isset($_GET['id'])) {
    $id_kategori = $_GET['id'];

    if (!empty($id_kategori)) {
        $sql = "DELETE FROM kategori WHERE id_kategori = '{$id_kategori}';";
        $query = mysqli_query($db_conn, $sql);
        if (!$query) {
            echo "<script>alert('Data sedang berelasi dengan tabel lain');</script>";
        }
    } else {
        echo "<script>alert('ID kategori kosong!');</script>";
    }
} else {
    echo "<script>alert('ID kategori tidak didefinisikan!');</script>";
}

echo "<script>alert('Data berhasil di hapus');</script>";
echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
