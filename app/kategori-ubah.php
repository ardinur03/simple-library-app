<?php

if (!isset($_POST['simpan'])) {
    if (isset($_GET['id'])) {
        $id_kategori = $_GET['id'];
        if (!empty($id_kategori)) {
            $sql = "SELECT * FROM kategori WHERE id_kategori = '{$id_kategori}';";
            $query = mysqli_query($db_conn, $sql);
            $row = $query->num_rows;

            if ($row > 0) {
                $data = mysqli_fetch_array($query);
            } else {
                echo "<script>alert('ID kategori tidak ditemukan!');</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
                exit;
            }
        } else {
            echo "<script>alert('ID kategori kosong!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
            exit;
        }
    } else {
        echo "<script>alert('ID kategori tidak didefinisikan!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
        exit;
    }
?>

    <section id="kategori-section">
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=kategori" class="text-decoration-none">Daftar Kategori</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah Kategori</li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Edit Data Kategori</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="input-id-kategori">ID kategori</label>
                                    <input type="text" class="form-control form-control-disable" name="id_kategori" value="<?= $data['id_kategori']; ?>" id="input-id-kategori" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="input-nama_kategori">Nama kategori</label>
                                    <input type="text" class="form-control" name="nama_kategori" value="<?= $data['nama_kategori']; ?>" id="input-nama-kategori" placeholder="Masukkan Nama kategori ..." required>
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
    $id_kategori   = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];
    $sql = "UPDATE kategori 
                SET nama_kategori = '{$nama_kategori}'
				WHERE id_kategori = '{$id_kategori}'";
    $query = mysqli_query($db_conn, $sql);
    if (!$query) {
        echo "<script>alert('Data gagal diubah!');</script>";
    }

    // mengalihkan halaman
    echo "<script>alert('Data berhasil di ubah');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
}
?>