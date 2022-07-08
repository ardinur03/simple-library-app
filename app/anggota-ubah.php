<?php

if (!isset($_POST['simpan'])) {
	if (isset($_GET['id'])) { // memperoleh anggota_id
		$id_anggota = $_GET['id'];

		if (!empty($id_anggota)) {
			// Query
			$sql = "SELECT * FROM anggota WHERE id_anggota = '{$id_anggota}';";
			$query = mysqli_query($db_conn, $sql);
			$row = $query->num_rows;

			if ($row > 0) {
				$data = mysqli_fetch_array($query); // memperoleh data anggota
			} else {
				echo "<script>alert('ID Anggota tidak ditemukan!');</script>";

				// mengalihkan halaman
				echo "<meta http-equiv='refresh' content='0; url=index.php?p=anggota'>";
				exit;
			}
		} else {
			echo "<script>alert('ID Anggota kosong!');</script>";

			// mengalihkan halaman
			echo "<meta http-equiv='refresh' content='0; url=index.php?p=anggota'>";
			exit;
		}
	} else {
		echo "<script>alert('ID Anggota tidak didefinisikan!');</script>";

		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=anggota'>";
		exit;
	}
?>

	<div class="container mt-5">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=anggota" class="text-decoration-none">Daftar Anggota</a></li>
				<li class="breadcrumb-item active" aria-current="page">Ubah Anggota</li>
			</ol>
		</nav>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h4 class="text-center">Edit Data Anggota</h4>
					</div>
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="id_anggota">ID Anggota</label>
								<input type="text" class="form-control form-control-disable" name="id_anggota" value="<?php echo $data['id_anggota']; ?>" id="id_anggota" readonly>
							</div>
							<div class="form-group">
								<label for="nama_lengkap">Nama Lengkap</label>
								<input type="" class="form-control" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>" id="nama_lengkap" placeholder="Masukkan Nama Lengkap ..." required>
							</div>
							<div class="form-group">
								<label for="">Jenis Kelamin</label>
								<div class="form-check">
									<input class="form-check-input" value="L" type="radio" name="jenis_kelamin" <?php echo ($data['jenis_kelamin'] == 'L') ? 'checked' : ''; ?> id="jk_pria">
									<label class="form-check-label" for="jk_pria">
										Pria
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" value="W" type="radio" name="jenis_kelamin" <?php echo ($data['jenis_kelamin'] == 'P') ? 'checked' : ''; ?> id="jk_wanita">
									<label class="form-check-label" for="jk_wanita">
										Wanita
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat">Alamat</label>
								<textarea type="" class="form-control" name="alamat" id="alamat" placeholder="Masukkan Alamat ..."><?php echo $data['alamat']; ?></textarea>
							</div>
							<label for="foto">Foto</label>
							<div class="custom-file">
								<label class="custom-file-label" for="foto">Pilih File</label>
								<input type="file" class="custom-file-input" name="foto" id="foto">
								<input type="hidden" name="foto_tmp" id="foto_tmp" value="<?php echo $data['foto']; ?>">

							</div>

							<div class="form-group">
								<label for="">Status Aktif</label>
								<div class="form-check">
									<input class="form-check-input" value="Y" type="radio" name="status_aktif" <?php echo ($data['status_aktif'] == 'Y') ? 'checked' : ''; ?> id="status_true" required>
									<label class="form-check-label" for="status_true">
										Ya
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" value="T" type="radio" name="status_aktif" <?php echo ($data['status_aktif'] == 'T') ? 'checked' : ''; ?> id="status_false" required>
									<label class="form-check-label" for="status_false">
										Tidak
									</label>
								</div>
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

<?php
} else {
	/* Proses Penyimpanan Data dari Form */
	$id_anggota 	= $_POST['id_anggota'];
	$nama_lengkap 	= $_POST['nama_lengkap'];
	$jenis_kelamin	= $_POST['jenis_kelamin'];
	$alamat			= $_POST['alamat'];
	$file_foto 		= $_FILES['foto']['name'];
	$file_foto_tmp	= $_POST['foto_tmp'];
	$status_aktif	= $_POST['status_aktif'];

	if (!empty($file_foto)) {
		// Rename file foto. Contoh: foto-AG007.jpg
		$ext_file = pathinfo($file_foto, PATHINFO_EXTENSION);
		$file_foto_rename = 'foto-' . $id_anggota . '.' . $ext_file;

		$dir_images = './images/';
		$path_image = $dir_images . $file_foto_rename;
		$file_foto = $file_foto_rename; // untuk keperluan Query UPDATE

		// Jika file foto sudah tersedia
		if (file_exists($path_image)) {
			unlink($path_image); // file foto dihapus
		}

		move_uploaded_file($_FILES['foto']['tmp_name'], $path_image);
	} else {
		$file_foto = $file_foto_tmp; // jika tidak diubah gunakan yang sudah ada sebelumnya
	}

	// Query
	$sql = "UPDATE anggota 
					SET nama_lengkap 	= '{$nama_lengkap}',
						jenis_kelamin 	= '{$jenis_kelamin}',
						alamat 			= '{$alamat}',
						foto			= '{$file_foto}', 
						status_aktif	= '{$status_aktif}'
					WHERE id_anggota	='{$id_anggota}'";
	$query = mysqli_query($db_conn, $sql);

	if (!$query) {
		echo "<script>alert('Data gagal diubah!');</script>";
	}

	// mengalihkan halaman
	echo "<script>alert('Data berhasil di ubah');</script>";

	echo "<meta http-equiv='refresh' content='0; url=index.php?p=anggota'>";
}
?>