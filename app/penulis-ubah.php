<?php

if (!isset($_POST['simpan'])) {
    if (isset($_GET['id'])) {
        $id_penulis = $_GET['id'];
        if (!empty($id_penulis)) {
            $sql = "SELECT * FROM penulis WHERE id_penulis = '{$id_penulis}';";
            $query = mysqli_query($db_conn, $sql);
            $row = $query->num_rows;

            if ($row > 0) {
                $data = mysqli_fetch_array($query);
            } else {
                echo "<script>alert('ID Penulis tidak ditemukan!');</script>";
                echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
                exit;
            }
        } else {
            echo "<script>alert('ID Penulis kosong!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
            exit;
        }
    } else {
        echo "<script>alert('ID Penulis tidak didefinisikan!');</script>";

        // mengalihkan halaman
        echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
        exit;
    }


?>

    <section id="penulis-section">
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=penulis" class="text-decoration-none">Daftar Penulis</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah Penulis</li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Edit Data Penulis</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="input-id_penulis">ID Penulis</label>
                                    <input type="text" class="form-control form-control-disable" name="id_penulis" value="<?= $data['id_penulis']; ?>" id="input-id_penulis" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="input-nama_penulis">Nama Penulis</label>
                                    <input type="text" class="form-control" name="nama_penulis" value="<?= $data['nama_penulis']; ?>" id="input-nama_penulis" placeholder="Masukkan Nama Penulis ..." required>
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
    $id_penulis   = $_POST['id_penulis'];
    $nama_penulis = $_POST['nama_penulis'];
    $sql = "UPDATE penulis 
                SET nama_penulis = '{$nama_penulis}'
				WHERE id_penulis = '{$id_penulis}'";
    $query = mysqli_query($db_conn, $sql);
    if (!$query) {
        echo "<script>alert('Data gagal diubah!');</script>";
    }

    // mengalihkan halaman
    echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
}
?>