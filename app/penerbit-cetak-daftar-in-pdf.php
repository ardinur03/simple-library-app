<?php

require_once '../vendor/autoload.php';
include '../helpers/helper_umum.php';
include '../config/koneksi-db.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', TRUE);
ob_start();

$sql = "SELECT * FROM penerbit ORDER BY id_penerbit ASC;";
$query = mysqli_query($db_conn, $sql);
$row = $query->num_rows;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Penerbit</title>
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
                <div class="col-md-auto">
                    <h3 class="text-center my-4">Daftar Penerbit</h3>

                    <table class="table table-bordered" style="width: 100%;">
                        <tr class="text-center">
                            <th>No.</th>
                            <th>ID Penerbit</th>
                            <th>Nama Penerbit</th>
                        </tr>
                        <?php
                        $i = 1;
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $data['id_penerbit']; ?></td>
                                <td><?= $data['nama_penerbit']; ?></td>

                            </tr>
                        <?php
                        }
                        ?>
                    </table>
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
$dompdf->stream("list-penerbit-buku-perpus.pdf");
?>