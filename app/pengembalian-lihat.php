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
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=pengembalian" class="text-decoration-none">Daftar Pengembalian</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lihat Pengembalian</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-primary p-3" role="alert">
                        NOTE : Di sini anda hanya bisa Melihat detailnya saja
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Lihat Detail Pengembalian</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="id-transaksi-input">ID Transaksi</label>
                                <input type="text" class="form-control form-control-disable" name="id_transaksi" value="<?= $data['id_transaksi']; ?>" id="id-transaksi-input" readonly>
                            </div>
                            <div class="form-group">
                                <label for="anggota">Nama Anggota</label>
                                <select class="form-control form-control-disable" id="anggota" disabled>
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
                                <select class="form-control form-control-disable" id="buku" disabled>
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
                            <div class="form-group">
                                <label for="pinjam">Tanggal Pinjam</label>
                                <input type="date" disabled class="form-control form-control-disable" value="<?= $data['tanggal_pinjam']; ?>" id="pinjam">
                            </div>
                            <div class="form-group">
                                <label for="pinjam">Tanggal Kembali</label>
                                <input type="date" name="tgl_kembali" class="form-control form-control-disable" value="<?= $data['tanggal_kembali']; ?>" readonly id="pinjam">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
}
?>