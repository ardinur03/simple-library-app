<?php

$row = 0;
$num = 0;
$offset = 0;
$limit_pagination = 5;

if (!isset($_POST['cari'])) {
    if (isset($_GET['num'])) {
        $num = (int)$_GET['num'];
        if ($num > 0) {
            $offset = ($num * $limit_pagination) - $limit_pagination;
        }
    }

    /* Query Main */
    $sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap AS nama_anggota, buku.judul_buku, transaksi.tanggal_kembali, transaksi.tanggal_pinjam, admin.nama_lengkap
        FROM transaksi
        JOIN anggota ON transaksi.id_anggota =  anggota.id_anggota
        JOIN buku ON transaksi.id_buku =  buku.id_buku
        JOIN admin ON transaksi.id_admin  = admin.id_admin
        WHERE transaksi.tanggal_kembali =  '0000-00-00'
        ORDER BY id_transaksi DESC LIMIT {$offset}, {$limit_pagination};";
    $query = mysqli_query($db_conn, $sql);

    /* Query Count All */
    $sql_count = "SELECT id_transaksi FROM transaksi WHERE transaksi.tanggal_kembali =  '0000-00-00';";
    $query_count = mysqli_query($db_conn, $sql_count);
    $row = $query_count->num_rows;
} else { // Jika melakukan pencarian anggota
    /*** Pencarian ***/
    $kata_kunci = $_POST['kata_kunci'];

    if (!empty($kata_kunci)) {
        /* Query Pencarian */
        $sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap AS nama_anggota, buku.judul_buku, transaksi.tanggal_kembali, transaksi.tanggal_pinjam, admin.nama_lengkap
                FROM transaksi
                JOIN anggota ON transaksi.id_anggota =  anggota.id_anggota
                JOIN buku ON transaksi.id_buku =  buku.id_buku
                JOIN admin ON transaksi.id_admin  = admin.id_admin
                WHERE id_transaksi LIKE '%{$kata_kunci}%'
                OR tanggal_pinjam LIKE '%{$kata_kunci}%'
                ORDER BY id_transaksi DESC;";
        $query = mysqli_query($db_conn, $sql);
        $row = $query->num_rows;
    }
}
?>

<section id="transaksi-section" class="h-auto">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-auto">
                <div class="page-title">
                    <h3>Data Transaksi Peminjaman</h3>
                </div>
            </div>
        </div>

        <div class="row justify-content-between mt-4">
            <div class="col-md-auto">
                <a href="index.php?p=peminjaman-tambah" class="btn btn-success">Tambah Peminjaman</a>

                <a href="./app/peminjaman-cetak-daftar-in-pdf.php" class="btn btn-light btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Convert ke pdf"> <i class="fas fa-print"></i> <span class="ml-1">convert & download pdf</span></a>
            </div>
            <div class="col-md-auto">
                <form name="pencarian_anggota" action="" method="post" class="form-inline my-2 my-lg-0">
                    <input type="text" name="kata_kunci" class="form-control mr-sm-2" placeholder="id Atau tanggal pinjam">
                    <input type="submit" name="cari" class="btn btn-outline-info my-2 my-sm-0" value="Cari">
                </form>
            </div>
        </div>
    </div>

    <?php
    if ($row > 0) {
    ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-transaksi table-sm table-responsive-sm table-striped table-hover mt-4" style="width: 100%;">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th>ID Transaksi</th>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th>Terakhir di edit oleh</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $data['id_transaksi']; ?></td>
                                <td><?= $data['nama_anggota']; ?></td>
                                <td><?= $data['judul_buku']; ?></td>
                                <td class="text-center"><?= $data['tanggal_pinjam']; ?></td>
                                <td class="text-center">
                                    <span class="badge  <?= $data['tanggal_kembali'] == '0000-00-00' ? 'badge-danger' : 'badge-success' ?>">
                                        <?= $data['tanggal_kembali'] == '0000-00-00' ? 'Buku belum di kembalikan' : 'Sudah Di kembalikan : ' . $data['tanggal_kembali']; ?>
                                    </span>
                                </td>
                                <td class="text-center"><?= $data['nama_lengkap']; ?></td>
                                <td class="text-center">
                                    <a href="index.php?p=peminjaman-ubah&id=<?= $data['id_transaksi']; ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="index.php?p=peminjaman-kembali&id=<?= $data['id_transaksi']; ?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Kembalikan Buku">Dikembalikan</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row justify-content-between">
            <div class="col-md-auto">
                <div class="table-lower-left mg-top-5">
                    Jumlah Data: <?= $row; ?>
                </div>
            </div>
            <div class="col-md-auto">
                <ul class="pagination">

                    <?php if (!isset($_POST['cari'])) { // disable pagination untuk pencarian 
                    ?>
                        <nav aria-label="...">
                            <ul class="pagination">
                                <?php
                                $page_num = ceil($row / $limit_pagination);

                                for ($i = 1; $i <= $page_num; $i++) {
                                ?>
                                    <li class="page-item <?php echo ($num == $i || ($num == 0 && $i == 1)) ? 'active' : '' ?>" aria-current="page">
                                        <a class="page-link bg-secondar" href="index.php?p=peminjaman&num=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>

                                <?php
                                }
                                ?>
                            </ul>
                        </nav>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    <?php } else { ?>
        <p class="text-center">Data tidak tersedia.</p>
    <?php } ?>
</section>