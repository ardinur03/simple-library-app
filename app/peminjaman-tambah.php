<?php

if (!isset($_POST['simpan'])) {
    // query untuk mencari id terakhir 
    $sql = "SELECT id_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1;";
    $query = mysqli_query($db_conn, $sql);

    // improvisasi, conditional
    $query = mysqli_fetch_array($query);

    // cek jika ada tambahan, jika tidak ada makan buat dari primary ke 1
    if (isset($query['id_transaksi'])) {
        $id_transaksi_tmp = $query['id_transaksi'];
        $id_transaksi_tmp++;
    } else {
        $id_transaksi_tmp = 1;
        $id_transaksi_tmp = str_pad($id_transaksi_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
        $id_transaksi_tmp = 'AG' . $id_transaksi_tmp;
    }


    // ambil data anggota  
    $sql_anggota = "SELECT id_anggota, nama_lengkap FROM anggota WHERE anggota.status_aktif = \"Y\"";
    $anggota_data = mysqli_query($db_conn, $sql_anggota);

    // ambil data buku
    $sql_buku = "SELECT id_buku, judul_buku FROM buku WHERE buku.status = \"Tersedia\"";
    $buku_data = mysqli_query($db_conn, $sql_buku);

?>

    <section id="transaksi-section" class="h-auto">
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=peminjaman" class="text-decoration-none">Daftar peminjaman</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah peminjaman</li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Tambah Transaksi Peminjaman</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="id-transaksi-input">ID Transaksi</label>
                                    <input type="text" class="form-control form-control-disable" name="id_transaksi" value="<?php echo $id_transaksi_tmp; ?>" id="id-transaksi-input" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="anggota">Nama Anggota <span class="badge badge-secondary cursor-pointer" data-toggle="tooltip" data-placement="top" title="Anggota yang tersedia adalah anggota yang bestatus AKTIF (Anggota bisa meminjam lebih dari satu)"><i class="fas fa-info"></i></span></label>
                                    <select class="form-control" id="anggota" name="id_anggota" required>
                                        <option value="" hidden>*** Pilih Anggota ***</option>
                                        <?php foreach ($anggota_data as $key) {
                                        ?>
                                            <option value="<?= $key['id_anggota']; ?>"><?= $key['nama_lengkap']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="buku">Judul Buku <span class="badge badge-secondary cursor-pointer" data-toggle="tooltip" data-placement="top" title="Buku yang ada merupakan buku yang berstatus TERSEDIA (BELUM DIPINJAM)"><i class="fas fa-info"></i></span></label>
                                    <select class="form-control" id="buku" name="id_buku" required>
                                        <option value="" hidden>*** Pilih Buku ***</option>
                                        <?php foreach ($buku_data as $key) {
                                        ?>
                                            <option value="<?= $key['id_buku']; ?>"><?= $key['judul_buku']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pinjam">Tanggal Pinjam</label>
                                    <input type="date" name="tgl_pinjam" class="form-control" required id="pinjam">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="kembali">Tanggal Kembali</label>
                                    <input type="date" name="tgl_kembali" class="form-control" value="<#= $data['tanggal_kembali']; ?>" id="kembali">
                                </div> -->
                                <div class="form-group mt-4">
                                    <input type="submit" class="btn btn-block btn-success" name="simpan" value="Simpan">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
} else {
    $id_transaksi   = $_POST['id_transaksi'];
    $id_anggota     = $_POST['id_anggota'];
    $id_buku        = $_POST['id_buku'];
    $tgl_pinjam     = date('Y-m-d', strtotime($_POST['tgl_pinjam']));
    // $tgl_kembali     = date('Y-m-d', strtotime($_POST['tgl_kembali']));
    $tgl_kembali     = null;
    // get data admin yang melakukan insert
    $id_admin = $_SESSION['id_admin'];

    $sql = "INSERT INTO transaksi 
				VALUES('{$id_transaksi}', '{$id_anggota}' , '{$id_buku}', '{$tgl_pinjam}', '{$tgl_kembali}', '{$id_admin}')";


    $sql_buku = "UPDATE buku SET
        status = 'Dipinjam'
        WHERE id_buku = '{$id_buku}'";

    $query = mysqli_query($db_conn, $sql);
    $query = mysqli_query($db_conn, $sql_buku);

    if (!$query) {
        echo "<script>alert('ada kelasahan');</script>";
    }

    echo "<script>alert('Data berhasil di tambahkan');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php?p=peminjaman'>";
}
?>