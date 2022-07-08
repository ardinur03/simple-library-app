<?php

if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];

    if (!empty($id_transaksi)) {
        // $sql = "DELETE FROM transaksi WHERE id_transaksi = '{$id_transaksi}';";

        $sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap AS nama_anggota, buku.id_buku, buku.judul_buku, buku.status, transaksi.tanggal_kembali, transaksi.tanggal_pinjam, admin.nama_lengkap
        FROM transaksi
        JOIN anggota ON transaksi.id_anggota =  anggota.id_anggota
        JOIN buku ON transaksi.id_buku =  buku.id_buku
        JOIN admin ON transaksi.id_admin  = admin.id_admin
        WHERE id_transaksi = '{$id_transaksi}';";
        $query = mysqli_query($db_conn, $sql);
        $row = $query->num_rows;
        $data = mysqli_fetch_array($query);

        // echo "<script>alert('{$data['status']}');</script>";
        if ($data['status'] != 'Tersedia') {
            echo "<script>alert('Data gagal dihapus karena buku berstatus di pinjam oleh anggota !');</script>";
        } else {
            $sql_set_tanggal = "UPDATE transaksi 
            SET 
                transaksi.tanggal_kembali = '0000-00-00'
            WHERE id_transaksi = '{$id_transaksi}';";

            $sql_set_buku = "UPDATE buku 
            SET 
                buku.status = 'Dipinjam'
            WHERE id_buku = '{$data['id_buku']}';";

            $query = mysqli_query($db_conn, $sql_set_tanggal);
            $query = mysqli_query($db_conn, $sql_set_buku);
        }
    } else {
        echo "<script>alert('ID transaksi kosong!');</script>";
    }
} else {
    echo "<script>alert('ID transaksi tidak didefinisikan!');</script>";
}

echo "<meta http-equiv='refresh' content='0; url=index.php?p=pengembalian'>";
