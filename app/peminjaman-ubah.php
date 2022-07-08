<?php

if (!isset($_POST['simpan'])) {

    if (isset($_GET['id'])) {
        $id_transaksi = $_GET['id'];
        if (!empty($id_transaksi)) {
            // query untuk mencari id terakhir 
            $sql = "SELECT * FROM transaksi WHERE id_transaksi = '{$id_transaksi}';";
            $query = mysqli_query($db_conn, $sql);
            $row = $query->num_rows;

            // ambil data anggota
            $sql_anggota = "SELECT id_anggota, nama_lengkap FROM anggota";
            $anggota_data = mysqli_query($db_conn, $sql_anggota);

            // ambil data buku
            $sql_buku = "SELECT id_buku, judul_buku FROM buku";
            $buku_data = mysqli_query($db_conn, $sql_buku);

            if ($row > 0) {
                $data = mysqli_fetch_array($query);
            } else {
                echo "<script>alert('Data transaksi tidak ditemukan!');</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php?p=transaksi   '>";
                exit;
            }
        } else {
            echo "<script>alert('Data transaksi kosong!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?p=transaksi'>";
            exit;
        }
    }

?>

    <section id="transaksi-section" class="h-auto">
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=peminjaman" class="text-decoration-none">Daftar peminjaman</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit peminjaman</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-primary p-3" role="alert">
                        INFO : Anda bisa mambahkan/mengedit tanggal pengembalian di menu pengembalian <a href="<?= base_url(); ?>/index.php?p=pengembalian" class="btn btn-sm btn-danger">KLIK DiSINI</a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Edit Transaksi Peminjaman</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="id-transaksi-input">ID Transaksi</label>
                                    <input type="text" class="form-control form-control-disable" name="id_transaksi" value="<?= $data['id_transaksi']; ?>" id="id-transaksi-input" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="anggota">Nama Anggota</label>
                                    <select class="form-control" id="anggota" name="id_anggota" required>
                                        <option value="" hidden>*** Pilih Anggota ***</option>
                                        <?php foreach ($anggota_data as $key) {
                                        ?>
                                            <?php if ($key['id_anggota'] == $data['id_anggota']) { ?>
                                                <option value="<?= $key['id_anggota']; ?>" selected><?= $key['nama_lengkap']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $key['id_anggota']; ?>"><?= $key['nama_lengkap']; ?></option>

                                            <?php } ?>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="buku">Judul Buku</label>
                                    <select class="form-control" id="buku" name="id_buku" required>
                                        <option value="" hidden>*** Pilih Buku ***</option>
                                        <?php foreach ($buku_data as $key) {
                                        ?>
                                            <?php if ($key['id_buku'] == $data['id_buku']) { ?>
                                                <option value="<?= $key['id_buku']; ?>" selected><?= $key['judul_buku']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $key['id_buku']; ?>"><?= $key['judul_buku']; ?></option>

                                            <?php } ?>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="pinjam">Tanggal Pinjam</label>
                                    <input type="date" name="tgl_pinjam" class="form-control" value="<#= $data['tanggal_pinjam']; ?>" id="pinjam">
                                </div> -->
                                <!--<div class="form-group">
                                    <label for="pinjam">Tanggal Kembali</label>
                                    <input type="date" name="tgl_kembali" class="form-control" value="<#= $data['tanggal_kembali']; ?>" id="pinjam">
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
    // $tgl_pinjam     = date('Y-m-d', strtotime($_POST['tgl_pinjam']));
    // if (date('Y-m-d', strtotime($_POST['tgl_kembali'])) == '1970-01-01') {
    //     $_POST['tgl_kembali'] = null;
    //     $alert = "<script>alert('Data buku sudah di edit, Kini status buku $id_transaksi berstatus BELUM di KEMBALIKAN');</script>";
    // } else {
    //     $alert = "<script>alert('Data buku sudah di edit, dan Tanggal kembali sudah di tetapkan. Kini status buku $id_transaksi berstatus sudah di KEMBALIKAN, Anda bisa cek di menu Pengembalian');</script>";
    // }
    // $tgl_kembali    = $_POST['tgl_kembali'];
    $id_admin = $_SESSION['id_admin'];

    // -- transaksi.tanggal_pinjam = '{$tgl_pinjam}', 
    // -- transaksi.tanggal_kembali = '{$tgl_kembali}', 
    $sql = "UPDATE transaksi 
            SET  
            transaksi.id_anggota = '{$id_anggota}',
            transaksi.id_buku = '{$id_buku}',
            transaksi.id_admin = '{$id_admin}'
            WHERE id_transaksi = '{$id_transaksi}'";
    $query = mysqli_query($db_conn, $sql);

    if (!$query) {
        echo "<script>alert('ada kelasahan');</script>";
    } else {
        echo "<script>alert('Peminjaman Berhasil di update');</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php?p=peminjaman'>";
    }
}
?>