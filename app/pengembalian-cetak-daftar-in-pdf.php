<?php

require_once '../vendor/autoload.php';
include '../helpers/helper_umum.php';
include '../config/koneksi-db.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', TRUE);
ob_start();

include '../config/koneksi-db.php';

$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap AS nama_anggota, buku.judul_buku, transaksi.tanggal_kembali, transaksi.tanggal_pinjam, admin.nama_lengkap
        FROM transaksi
        JOIN anggota ON transaksi.id_anggota =  anggota.id_anggota
        JOIN buku ON transaksi.id_buku =  buku.id_buku
        JOIN admin ON transaksi.id_admin  = admin.id_admin
        WHERE transaksi.tanggal_kembali != '0000-00-00'
        ORDER BY id_transaksi ASC;";
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
    <style type="text/css">
        * {
            margin: 0px;
            padding: 0px;
        }

        .bg-secondary-custom {
            background-color: #76521c;
            color: #fafafa
        }

        .table th {
            font-size: 12px !important;
        }

        .table tr {
            font-size: 10px !important;
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
                    <h4 class="text-center my-4">Daftar Transaksi Pengembalian Selesai</h4>

                    <span class="mb-2">Tanggal Cetak : <?= date('Y-m-d') ?></span>
                    <table class="table table-striped table-bordered" style="width: 100%;">
                        <thead class="bg-secondary-custom">
                            <tr class="text-center">
                                <th>No</th>
                                <th>ID Transaksi</th>
                                <th>Nama Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Lama Peminjaman</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <?php
                        $i = 1;
                        while ($data = mysqli_fetch_array($query)) {
                            $tgl1 = $data['tanggal_pinjam'];
                            $tgl2 = $data['tanggal_kembali'];

                            $tanggal1 = new DateTime($tgl1);
                            $tanggal2 = new DateTime($tgl2);
                            $difference = $tanggal1->diff(($tanggal2));
                        ?>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td><?= $data['id_transaksi']; ?></td>
                                    <td><?= $data['nama_anggota']; ?></td>
                                    <td><?= $data['judul_buku']; ?></td>
                                    <td class="text-center"><?= $data['tanggal_pinjam']; ?></td>
                                    <td class="text-center"><?= $data['tanggal_kembali']; ?></td>
                                    <td class="text-center"><?= $difference->days == 0 ? 'Peminjaman tidak sampai 1 hari' : $difference->days; ?></td>
                                    <td class="text-center">Selesai</td>
                                </tr>
                            </tbody>
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
$dompdf->render();
$dompdf->stream("transaksi-pengembalian-perpus.pdf");
?>