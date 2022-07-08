<?php

require_once($_PATH_VENDOR . '/vendor/autoload.php');
include '../helpers/helper_umum.php';
include '../config/koneksi-db.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', TRUE);
ob_start();


$sql = "SELECT * FROM anggota ORDER BY id_anggota DESC;";
$query = mysqli_query($db_conn, $sql);
$row = $query->num_rows;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Anggota</title>
    <link rel="stylesheet" media="screen" href="<?= base_url(); ?>/vendor/bootstrap-4-3/css/bootstrap.min.css">
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>

<body>
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-auto">
                <?php
                if ($row > 0) {
                ?>
                    <h3 class="text-center my-4">Daftar Anggota</h3>

                    <table class="table table-bordered" style="width: 100%;">
                        <tr>
                            <th>No.</th>
                            <th>ID Anggota</th>
                            <th>Nama Lengkap</th>
                            <th>Foto</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Status Aktif</th>
                        </tr>
                        <?php
                        $i = 1;
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $data['id_anggota']; ?></td>
                                <td><?= $data['nama_lengkap']; ?></td>
                                <td class="text-center">
                                    <?php
                                    $data_foto = $data['foto'];
                                    if ($data_foto == '-') {
                                        $data_foto = 'foto-default.jpg';
                                    }
                                    ?>
                                    <img src="<?= base_url('/images/') . $data_foto; ?>" width="60">
                                </td>
                                <td><?= ($data['jenis_kelamin'] == 'L') ? 'Pria' : 'Wanita'; ?></td>
                                <td><?= $data['alamat']; ?></td>
                                <td class="text-center"><?= ($data['status_aktif'] == 'Y') ? 'Ya' : 'Tidak'; ?></td>
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
// $dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("list-anggota-perpus.pdf");
?>