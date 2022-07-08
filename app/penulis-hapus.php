<?php

if (isset($_GET['id'])) {
    $id_penulis = $_GET['id'];

    if (!empty($id_penulis)) {
        $sql = "DELETE FROM penulis WHERE id_penulis = '{$id_penulis}';";
        $query = mysqli_query($db_conn, $sql);
        if (!$query) {
            echo "<script>alert('Data sedang berelasi dengan tabel lain');</script>";
        }
    } else {
        echo "<script>alert('ID Penulis kosong!');</script>";
    }
} else {
    echo "<script>alert('ID Penulis tidak didefinisikan!');</script>";
}

echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
