<?php

$row = 0;
$num = 0;
$offset = 0;
if (!isset($_POST['cari'])) {
    if (isset($_GET['num'])) {
        $num = (int)$_GET['num'];
        if ($num > 0) {
            $offset = ($num * $_QUERY_LIMIT) - $_QUERY_LIMIT;
        }
    }

    /* Query Main */
    $sql = "SELECT buku.id_buku, buku.judul_buku, kategori.nama_kategori, penerbit.nama_penerbit, penulis.nama_penulis, buku.status
        FROM buku 
        JOIN kategori ON buku.id_kategori =  kategori.id_kategori
        JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
        JOIN penulis ON buku.id_penulis  = penulis.id_penulis
        ORDER BY id_buku DESC LIMIT {$offset}, {$_QUERY_LIMIT};";
    $query = mysqli_query($db_conn, $sql);

    /* Query Count All */
    $sql_count = "SELECT id_buku FROM buku;";
    $query_count = mysqli_query($db_conn, $sql_count);
    $row = $query_count->num_rows;
} else { // Jika melakukan pencarian anggota
    /*** Pencarian ***/
    $kata_kunci = $_POST['kata_kunci'];

    if (!empty($kata_kunci)) {
        /* Query Pencarian */
        $sql = "SELECT buku.id_buku, buku.judul_buku, kategori.nama_kategori, penerbit.nama_penerbit, penulis.nama_penulis, buku.status
                FROM buku 
                JOIN kategori ON buku.id_kategori =  kategori.id_kategori
                JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
                JOIN penulis ON buku.id_penulis  = penulis.id_penulis
                WHERE id_buku LIKE '%{$kata_kunci}%'
                    OR judul_buku LIKE '%{$kata_kunci}%'
                ORDER BY id_buku DESC;";
        $query = mysqli_query($db_conn, $sql);
        $row = $query->num_rows;
    }
}
?>

<section id="buku-section" class="h-auto">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-auto">
                <div class="page-title">
                    <h3>Data Buku</h3>
                </div>
            </div>
        </div>

        <div class="row justify-content-between mt-4">
            <div class="col-md-auto">
                <a href="index.php?p=buku-tambah" data-toggle="tooltip" data-placement="top" title="Tambah Data Buku" class="btn btn-success">Tambah</a>

                <a href="./app/buku-cetak-daftar-in-pdf.php" data-toggle="tooltip" data-placement="top" title="Convert ke pdf" class="btn btn-light btn-outline-danger"> <i class="fas fa-print"></i> <span class="ml-1">convert & download pdf</span></a>
            </div>
            <div class="col-md-auto">
                <form name="pencarian_anggota" action="" method="post" class="form-inline my-2 my-lg-0">
                    <input type="search" name="kata_kunci" class="form-control mr-sm-2" placeholder="Cari Id Atau Nama">
                    <input type="submit" name="cari" class="btn btn-outline-info my-2 my-sm-0" value="Cari">
                </form>
            </div>
        </div>
    </div>

    <?php
    if ($row > 0) {
    ?>
        <div class="row">
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
                            <td><?= $data['id_buku']; ?></td>
                            <td><?= $data['judul_buku']; ?></td>
                            <td><?= $data['nama_kategori']; ?></td>
                            <td><?= $data['nama_penerbit']; ?></td>
                            <td><?= $data['nama_penulis']; ?></td>
                            <td><span class="badge badge-<?= $data['status'] == 'Tersedia' ? 'success' : 'warning' ?>"><?= $data['status']; ?></span></td>
                            <td class="text-center">
                                <a href="index.php?p=buku-ubah&id=<?= $data['id_buku']; ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                <a href="index.php?p=buku-hapus&id=<?= $data['id_buku']; ?>" class="btn btn-sm btn-danger confirm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
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
                                $page_num = ceil($row / $_QUERY_LIMIT);

                                for ($i = 1; $i <= $page_num; $i++) {
                                ?>
                                    <li class="page-item <?php echo ($num == $i || ($num == 0 && $i == 1)) ? 'active' : '' ?>" aria-current="page">
                                        <a class="page-link bg-light" href="index.php?p=buku&num=<?php echo $i; ?>"><?php echo $i; ?></a>
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