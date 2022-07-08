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
    $sql = "SELECT * FROM penulis ORDER BY id_penulis DESC LIMIT {$offset}, {$_QUERY_LIMIT};";
    $query = mysqli_query($db_conn, $sql);

    /* Query Count All */
    $sql_count = "SELECT id_penulis FROM penulis;";
    $query_count = mysqli_query($db_conn, $sql_count);
    $row = $query_count->num_rows;
} else { // Jika melakukan pencarian anggota
    /*** Pencarian ***/
    $kata_kunci = $_POST['kata_kunci'];

    if (!empty($kata_kunci)) {
        /* Query Pencarian */
        $sql = "SELECT * FROM penulis 
					WHERE id_penulis LIKE '%{$kata_kunci}%'
						OR nama_penulis LIKE '%{$kata_kunci}%'
					ORDER BY id_penulis DESC;";
        $query = mysqli_query($db_conn, $sql);
        $row = $query->num_rows;
    }
}
?>

<section id="penulis-section" class="h-auto">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-auto">
                <div class="page-title">
                    <h3>Data Penulis</h3>
                </div>
            </div>
        </div>

        <div class="row justify-content-between mt-4">
            <div class="col-md-auto">
                <a href="index.php?p=penulis-tambah" data-toggle="tooltip" data-placement="top" title="Tambah Data Penulis" class="btn btn-success">Tambah</a>

                <a href="./app/penulis-cetak-daftar-in-pdf.php" data-toggle="tooltip" data-placement="top" title="Convert ke pdf" class="btn btn-light btn-outline-danger"> <i class="fas fa-print"></i> <span class="ml-1">convert & download pdf</span></a>
            </div>
            <div class="col-md-auto">
                <form name="pencarian_anggota" action="" method="post" class="form-inline my-2 my-lg-0">
                    <input type="text" name="kata_kunci" class="form-control mr-sm-2" placeholder="Cari Id Atau Nama">
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
                        <th>ID Anggota</th>
                        <th>Nama Lengkap Penulis</th>
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
                            <td><?= $data['id_penulis']; ?></td>
                            <td><?= $data['nama_penulis']; ?></td>
                            <td class="text-center">
                                <a href="index.php?p=penulis-ubah&id=<?= $data['id_penulis']; ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                <a href="index.php?p=penulis-hapus&id=<?= $data['id_penulis']; ?>" class="btn btn-sm btn-danger confirm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></a>
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
                                        <a class="page-link bg-secondar" href="index.php?p=penulis&num=<?php echo $i; ?>"><?php echo $i; ?></a>
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