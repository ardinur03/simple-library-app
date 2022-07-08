<?php
include './config/koneksi-db.php';

if (!isset($_POST['simpan'])) {
    if (isset($_GET['id'])) {
        $id_penerbit = $_GET['id'];
        if (!empty($id_penerbit)) {
            $sql = "SELECT * FROM penerbit WHERE id_penerbit = '{$id_penerbit}';";
            $query = mysqli_query($db_conn, $sql);
            $row = $query->num_rows;

            if ($row > 0) {
                $data = mysqli_fetch_array($query);
            } else {
                echo "<script>alert('ID penerbit tidak ditemukan!');</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
                exit;
            }
        } else {
            echo "<script>alert('ID penerbit kosong!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
            exit;
        }
    } else {
        echo "<script>alert('ID penerbit tidak didefinisikan!');</script>";

        // mengalihkan halaman
        echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
        exit;
    }


?>

    <section id="penerbit-section">
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=penerbit" class="text-decoration-none">Daftar Penerbit</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah Penerbit</li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Edit Data Penerbit</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="input-id_penerbit">ID Penerbit</label>
                                    <input type="text" class="form-control form-control-disable" name="id_penerbit" value="<?= $data['id_penerbit']; ?>" id="input-id_penerbit" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="input-nama_penerbit">Nama Penerbit</label>
                                    <input type="text" class="form-control" name="nama_penerbit" value="<?= $data['nama_penerbit']; ?>" id="input-nama_penerbit" placeholder="Masukkan Nama penerbit ..." required>
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
    $id_penerbit   = $_POST['id_penerbit'];
    $nama_penerbit = $_POST['nama_penerbit'];
    $sql = "UPDATE penerbit 
                SET nama_penerbit = '{$nama_penerbit}'
				WHERE id_penerbit = '{$id_penerbit}'";
    $query = mysqli_query($db_conn, $sql);
    if (!$query) {
        echo "<script>alert('Data gagal diubah!');</script>";
    }

    // mengalihkan halaman
    echo "<script>alert('Data berhasil di ubah');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
}
?>