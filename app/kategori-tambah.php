<?php

if (!isset($_POST['simpan'])) {
    $sql = "SELECT id_kategori FROM kategori ORDER BY id_kategori DESC LIMIT 1;";
    $query = mysqli_query($db_conn, $sql);

    // improvisasi, conditional
    $query = mysqli_fetch_array($query);

    if (isset($query['id_kategori'])) {
        $id_kategori_tmp = $query['id_kategori'];
        $id_kategori_tmp++;
    } else {
        $id_kategori_tmp = 1;
        $id_kategori_tmp = str_pad($id_kategori_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
        $id_kategori_tmp = 'PB' . $id_kategori_tmp;
    }

?>

    <section id="kategori-section">
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=kategori" class="text-decoration-none">Daftar Kategori</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Tambah Data Kategori</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="input-id-kategori">ID Kategori</label>
                                    <input type="text" class="form-control form-control-disable" name="id_kategori" value="<?= $id_kategori_tmp; ?>" id="input-id-kategori" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="input-nama-kategori">Nama Kategori</label>
                                    <input type="text" class="form-control" name="nama_kategori" id="input-nama-kategori" placeholder="Masukkan Nama kategori ..." required>
                                </div>
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
    /* Proses Penyimpanan Data dari Form */
    $id_kategori   = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    // Query
    $sql = "INSERT INTO kategori 
				VALUES('{$id_kategori}', '{$nama_kategori}')";
    $query = mysqli_query($db_conn, $sql);

    // mengalihkan halaman
    echo "<script>alert('Data berhasil di tambahkan');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
}
?>