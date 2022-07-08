<?php

if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];

    if (!empty($id_transaksi)) {

        $sql = "SELECT * FROM transaksi WHERE id_transaksi = '{$id_transaksi}';";
        $query = mysqli_query($db_conn, $sql);
        $row = $query->num_rows;
        $data = mysqli_fetch_array($query);

        $sql_set_tanggal = "UPDATE transaksi 
            SET 
                transaksi.tanggal_kembali = now()
            WHERE id_transaksi = '{$id_transaksi}';
             ";

        $sql_set_buku = "UPDATE buku 
            SET 
                buku.status = 'Tersedia'
            WHERE id_buku = '{$data['id_buku']}';
             ";

        $query = mysqli_query($db_conn, $sql_set_tanggal);
        $query = mysqli_query($db_conn, $sql_set_buku);

        try {
            if ($query) {
                echo "<script>alert('Buku berhasil Dikembalikan!');</script>";
            }
        } catch (\Throwable $th) {
            echo "<script>alert('{$th}');</script>";
        }
    } else {
        echo "<script>alert('ID transaksi kosong!');</script>";
    }
} else {
    echo "<script>alert('ID transaksi tidak didefinisikan!');</script>";
}

echo "<meta http-equiv='refresh' content='0; url=index.php?p=peminjaman'>";
