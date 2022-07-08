<?php

$row = 0;
$num = 0;
$offset = 0;
if (!isset($_POST['cari'])) { // Jika tidak melakukan pencarian anggota
	/*** Pagination ***/
	if (isset($_GET['num'])) { // Jika menggunakan pagination
		$num = (int)$_GET['num'];

		if ($num > 0) {
			$offset = ($num * $_QUERY_LIMIT) - $_QUERY_LIMIT;
		}
	}

	/* Query Main */
	$sql = "SELECT * FROM anggota ORDER BY id_anggota DESC LIMIT {$offset}, {$_QUERY_LIMIT};";
	$query = mysqli_query($db_conn, $sql);

	/* Query Count All */
	$sql_count = "SELECT id_anggota FROM anggota;";
	$query_count = mysqli_query($db_conn, $sql_count);
	$row = $query_count->num_rows;
} else { // Jika melakukan pencarian anggota
	/*** Pencarian ***/
	$kata_kunci = $_POST['kata_kunci'];

	if (!empty($kata_kunci)) {
		/* Query Pencarian */
		$sql = "SELECT * FROM anggota 
					WHERE id_anggota LIKE '%{$kata_kunci}%'
						OR nama_lengkap LIKE '%{$kata_kunci}%'
						OR alamat LIKE '%{$kata_kunci}%'
					ORDER BY id_anggota DESC;";
		$query = mysqli_query($db_conn, $sql);
		$row = $query->num_rows;
	}
}
?>

<section id="anggota-section" class="h-auto">
	<div class="container mt-5">
		<div class="row">
			<div class="col-md-auto">
				<div class="page-title">
					<h3>Data Anggota</h3>
				</div>
			</div>
		</div>
		<div class="row justify-content-between mt-4">
			<div class="col-md-auto">
				<a href="index.php?p=anggota-tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data Anggota Perpustakaan">Tambah</a>
				<a href="<?= $_PATH_APP; ?>/anggota-cetak-daftar-in-pdf.php" data-toggle="tooltip" data-placement="top" title="Convert ke pdf" class="btn btn-light btn-outline-danger"> <i class="fas fa-print"></i> <span class="ml-1">convert & download pdf</span></a>
			</div>
			<div class="col-md-auto">
				<form name="pencarian_anggota" action="" method="post" class="form-inline my-2 my-lg-0">
					<input type="text" name="kata_kunci" class="form-control mr-sm-2" placeholder="Cari Berdasarkan Id">
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
				<thead class="text-center">
					<tr>
						<th class="text-center">No</th>
						<th>ID Anggota</th>
						<th>Nama Lengkap Anggota</th>
						<th>Foto</th>
						<th>Jenis Kelamin</th>
						<th>Alamat</th>
						<th>Status KeAnggotaan</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					while ($data = mysqli_fetch_array($query)) {
					?>
						<tr>
							<td class="text-center"><?= $i++; ?></td>
							<td><?= $data['id_anggota']; ?></td>
							<td><?= $data['nama_lengkap']; ?></td>
							<td>
								<?php
								$data_foto = $data['foto'];
								if ($data_foto == '-') {
									$data_foto = 'foto-default.jpg';
								}
								?>
								<img src="<?= './images/' . $data_foto; ?>" width="60">
							</td>
							<td><?= ($data['jenis_kelamin'] == 'L') ? 'Pria' : 'Wanita'; ?></td>
							<td><?= $data['alamat']; ?></td>
							<td class="text-center">
								<span class="badge <?= ($data['status_aktif'] == 'Y') ? 'badge-success' : 'badge-danger'; ?>">
									<?= ($data['status_aktif'] == 'Y') ? 'Aktif' : 'Tidak Aktif'; ?>
								</span>
							</td>
							<td class="text-center">
								<a href="./app/anggota-cetak-kartu.php?&id=<?= $data['id_anggota']; ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Cetak Kartu Anggota Perpustakaan"><i class="fas fa-address-card"></i></a>
								<a href="index.php?p=anggota-ubah&id=<?= $data['id_anggota']; ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></a>
								<a href="index.php?p=anggota-hapus&id=<?= $data['id_anggota']; ?>" class="btn btn-sm btn-danger confirm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></a>
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
										<a class="page-link bg-secondar" href="index.php?p=anggota&num=<?php echo $i; ?>"><?php echo $i; ?></a>
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