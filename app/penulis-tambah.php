<?php

if (!isset($_POST['simpan'])) {
    $sql = "SELECT id_penulis FROM penulis ORDER BY id_penulis DESC LIMIT 1;";
    $query = mysqli_query($db_conn, $sql);

    // improvisasi, conditional
    $query = mysqli_fetch_array($query);
    if (isset($query['id_penulis'])) {
        $id_penulis_tmp = $query['id_penulis'];
        $id_penulis_tmp++;
    } else {
        $id_penulis_tmp = 1;
        $id_penulis_tmp = str_pad($id_penulis_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
        $id_penulis_tmp = 'PN' . $id_penulis_tmp;
    }

?>

    <section id="penulis-section">
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=penulis" class="text-decoration-none">Daftar Penulis</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Penulis</li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Tambah Data Penulis</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="input-id_penulis">ID Penulis</label>
                                    <input type="text" class="form-control form-control-disable" name="id_penulis" value="<?= $id_penulis_tmp; ?>" id="input-id_penulis" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="input-nama_penulis">Nama Penulis</label>
                                    <input type="text" class="form-control" name="nama_penulis" id="input-nama_penulis" placeholder="Masukkan Nama Penulis ..." required>
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
    $id_penulis   = $_POST['id_penulis'];
    $nama_penulis = $_POST['nama_penulis'];

    // Query
    $sql = "INSERT INTO penulis 
				VALUES('{$id_penulis}', '{$nama_penulis}')";
    $query = mysqli_query($db_conn, $sql);

    // mengalihkan halaman
    echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
}
?>