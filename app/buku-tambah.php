<?php

if (!isset($_POST['simpan'])) {
    // query untuk mencari id terakhir 
    $sql = "SELECT id_buku FROM buku ORDER BY id_buku DESC LIMIT 1;";
    $query = mysqli_query($db_conn, $sql);

    // improvisasi, conditional
    $query = mysqli_fetch_array($query);

    // cek jika ada tambahan, jika tidak ada makan buat dari primary ke 1
    if (isset($query['id_buku'])) {
        $id_buku_tmp = $query['id_buku'];
        $id_buku_tmp++;
    } else {
        $id_buku_tmp = 1;
        $id_buku_tmp = str_pad($id_buku_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
        $id_buku_tmp = 'AG' . $id_buku_tmp;
    }


    // ambil data kategori
    $sql_kategori = "SELECT id_kategori, nama_kategori FROM kategori";
    $kategori_data = mysqli_query($db_conn, $sql_kategori);

    // ambil data penulis
    $sql_penulis = "SELECT id_penulis, nama_penulis FROM penulis";
    $penulis_data = mysqli_query($db_conn, $sql_penulis);

    // ambil data penerbit
    $sql_penerbit = "SELECT id_penerbit, nama_penerbit FROM penerbit";
    $penerbit_data = mysqli_query($db_conn, $sql_penerbit);
?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=buku" class="text-decoration-none">Daftar Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Buku</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Tambah Data Buku</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="id-buku-input">ID Buku</label>
                                <input type="text" class="form-control form-control-disable" name="id_buku" value="<?php echo $id_buku_tmp; ?>" id="id-buku-input" readonly>
                            </div>
                            <div class="form-group">
                                <label for="judul-buku-input">Nama Buku</label>
                                <input type="text" class="form-control" name="judul_buku" id="judul-buku-input" placeholder="Masukkan judul buku ..." required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Nama Kategori</label>
                                <select class="form-control" name="id_kategori" required>
                                    <option value="" hidden>*** Pilih Kategori ***</option>
                                    <?php foreach ($kategori_data as $key) {
                                    ?>
                                        <option value="<?= $key['id_kategori']; ?>"><?= $key['nama_kategori']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penerbit">Nama Penerbit</label>
                                <select class="form-control" name="id_penerbit" required>
                                    <option value="" hidden>*** Pilih Penerbit ***</option>
                                    <?php foreach ($penerbit_data as $key) {
                                    ?>
                                        <option value="<?= $key['id_penerbit']; ?>"><?= $key['nama_penerbit']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penulis">Nama Penulis</label>
                                <select class="form-control" name="id_penulis" required>
                                    <option value="" hidden>*** Pilih Penulis ***</option>
                                    <?php foreach ($penulis_data as $key) {
                                    ?>
                                        <option value="<?= $key['id_penulis']; ?>"><?= $key['nama_penulis']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
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

<?php
} else {
    $id_buku   = $_POST['id_buku'];
    $judul_buku   = $_POST['judul_buku'];
    $id_kategori  = $_POST['id_kategori'];
    $id_penulis   = $_POST['id_penulis'];
    $id_penerbit  = $_POST['id_penerbit'];
    $status       = "Tersedia";

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // die();

    $sql = "INSERT INTO buku 
				VALUES('{$id_buku}', '{$judul_buku}', '{$id_kategori}', '{$id_penulis}', '{$id_penerbit}', '{$status}')";
    $query = mysqli_query($db_conn, $sql);

    if (!$query) {
        echo "<script>alert('ada kelasahan');</script>";
    }

    echo "<script>alert('Data berhasil di tambahkan');</script>";

    echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
}
?>