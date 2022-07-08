<?php

if (!isset($_POST['simpan'])) {

    if (isset($_GET['id'])) {
        $id_buku = $_GET['id'];
        if (!empty($id_buku)) {
            $sql = "SELECT * FROM buku WHERE id_buku = '{$id_buku}';";
            $query = mysqli_query($db_conn, $sql);
            $row = $query->num_rows;

            // ambil data kategori
            $sql_kategori = "SELECT id_kategori, nama_kategori FROM kategori";
            $kategori_data = mysqli_query($db_conn, $sql_kategori);

            // ambil data penulis
            $sql_penulis = "SELECT id_penulis, nama_penulis FROM penulis";
            $penulis_data = mysqli_query($db_conn, $sql_penulis);

            // ambil data penerbit
            $sql_penerbit = "SELECT id_penerbit, nama_penerbit FROM penerbit";
            $penerbit_data = mysqli_query($db_conn, $sql_penerbit);

            if ($row > 0) {
                $data = mysqli_fetch_array($query);
            } else {
                echo "<script>alert('Data buku tidak ditemukan!');</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku   '>";
                exit;
            }
        } else {
            echo "<script>alert('Data buku kosong!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
            exit;
        }
    }


?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=buku" class="text-decoration-none">Daftar Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubah Buku</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Edit Data Buku</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="id-buku-input">ID Buku</label>
                                <input type="text" class="form-control form-control-disable" name="id_buku" value="<?= $data['id_buku']; ?>" id="id-buku-input" readonly>
                            </div>
                            <div class="form-group">
                                <label for="judul-buku-input">Nama Buku</label>
                                <input type="text" class="form-control" value="<?= $data['judul_buku']; ?>" name="judul_buku" id="judul-buku-input" placeholder="Masukkan judul buku ..." required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Nama Kategori</label>
                                <select class="form-control" name="id_kategori" required>
                                    <option value="" hidden>*** Pilih Kategori ***</option>
                                    <?php foreach ($kategori_data as $key) {
                                    ?>
                                        <?php if ($key['id_kategori'] == $data['id_kategori']) { ?>
                                            <option value="<?= $key['id_kategori']; ?>" selected><?= $key['nama_kategori']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $key['id_kategori']; ?>"><?= $key['nama_kategori']; ?></option>
                                        <?php } ?>
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
                                        <?php if ($key['id_penerbit'] == $data['id_penerbit']) { ?>
                                            <option value="<?= $key['id_penerbit']; ?>" selected><?= $key['nama_penerbit']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $key['id_penerbit']; ?>"><?= $key['nama_penerbit']; ?></option>
                                        <?php } ?>
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
                                        <?php if ($key['id_penulis'] == $data['id_penulis']) { ?>
                                            <option value="<?= $key['id_penulis']; ?>" selected><?= $key['nama_penulis']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $key['id_penulis']; ?>"><?= $key['nama_penulis']; ?></option>
                                        <?php } ?>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penulis">Status Buku</label>
                                <select class="form-control" name="status_buku" required>
                                    <?php
                                    $value_status = $data['status'] == 'Dipinjam' ? 'Tersedia' : 'Dipinjam';
                                    if ($data['status'] == 'Tersedia') { ?>
                                        <option value="Tersedia" selected>Tersedia</option>
                                    <?php } elseif ($data['status'] == 'Dipinjam') { ?>
                                        <option value="Dipinjam" selected>Dipinjam</option>
                                    <?php }  ?>
                                    <option value="<?= $value_status  ?>"><?= $value_status ?></option>
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
    $status       = $_POST['status_buku'];

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // die();

    $sql = "UPDATE buku 
            SET  
            buku.judul_buku = '{$judul_buku}',
            buku.id_kategori = '{$id_kategori}', 
            buku.id_penulis = '{$id_penulis}', 
            buku.id_penerbit = '{$id_penerbit}',
            buku.status = '{$status}'
            WHERE id_buku = '{$id_buku}'";
    $query = mysqli_query($db_conn, $sql);

    if (!$query) {
        echo "<script>alert('ada kelasahan');</script>";
    }


    echo "<script>alert('Data berhasil di ubah');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
}
?>