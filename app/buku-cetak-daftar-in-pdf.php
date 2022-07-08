<?php

require_once '../vendor/autoload.php';
include '../helpers/helper_umum.php';
include '../config/koneksi-db.php';


use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', TRUE);
ob_start();

$sql = "SELECT buku.id_buku, buku.judul_buku, kategori.nama_kategori, penerbit.nama_penerbit, penulis.nama_penulis, buku.status
    FROM buku 
    JOIN kategori ON buku.id_kategori =  kategori.id_kategori
    JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
    JOIN penulis ON buku.id_penulis  = penulis.id_penulis;";
$query = mysqli_query($db_conn, $sql);
$row = $query->num_rows;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Buku</title>
    <link rel="stylesheet" media="screen" href="<?= base_url(); ?>/vendor/bootstrap-4-3/css/bootstrap.min.css">
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>

<body>
    <?php
    if ($row > 0) {
    ?>
        <section class="container">
            <div class="row justify-content-center">
                <div class="row">
                    <div class="col-md-auto">
                        <h3 class="text-center   my-4">Daftar Buku</h3>
                        <table class="table table-striped table-hover mt-4">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>ID Buku</th>
                                    <th>Judul Buku</th>
                                    <th>Nama Kategori</th>
                                    <th>Nama Penerbit</th>
                                    <th>Nama Penulis</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td><?= $data['id_buku']; ?></td>
                                        <td><?= $data['judul_buku']; ?></td>
                                        <td><?= $data['nama_kategori']; ?></td>
                                        <td><?= $data['nama_penerbit']; ?></td>
                                        <td><?= $data['nama_penulis']; ?></td>
                                        <td><?= $data['status']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    <?php
    }
    ?>
</body>

</html>
<?php
$html = ob_get_clean();
$dompdf->load_html($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("list-buku-perpus.pdf");
?>