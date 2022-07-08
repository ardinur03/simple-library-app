<?php
include './config/koneksi-db.php';

if (!isset($_POST['simpan'])) {
    $sql = "SELECT id_penerbit FROM penerbit ORDER BY id_penerbit DESC LIMIT 1;";
    $query = mysqli_query($db_conn, $sql);

    // improvisasi, conditional
    $query = mysqli_fetch_array($query);
    if (isset($query['id_penerbit'])) {
        $id_penerbit_tmp = $query['id_penerbit'];
        $id_penerbit_tmp++;
    } else {
        $id_penerbit_tmp = 1;
        $id_penerbit_tmp = str_pad($id_penerbit_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
        $id_penerbit_tmp = 'PB' . $id_penerbit_tmp;
    }

?>

    <section id="penerbit-section">
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
                            <h4 class="text-center">Tambah Data Penerbit</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="input-id-penerbit">ID Penerbit</label>
                                    <input type="text" class="form-control form-control-disable" name="id_penerbit" value="<?= $id_penerbit_tmp; ?>" id="input-id-penerbit" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="input-nama-penerbit">Nama Penerbit</label>
                                    <input type="text" class="form-control" name="nama_penerbit" id="input-nama-penerbit" placeholder="Masukkan Nama penerbit ..." required>
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
    $id_penerbit   = $_POST['id_penerbit'];
    $nama_penerbit = $_POST['nama_penerbit'];

    // Query
    $sql = "INSERT INTO penerbit 
				VALUES('{$id_penerbit}', '{$nama_penerbit}')";
    $query = mysqli_query($db_conn, $sql);

    // mengalihkan halaman
    echo "<script>alert('Data berhasil di tambah');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
}
?>