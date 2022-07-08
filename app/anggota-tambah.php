<?php

if (!isset($_POST['simpan'])) {
	// query untuk mencari id terakhir 
	$sql = "SELECT id_anggota FROM anggota ORDER BY id_anggota DESC LIMIT 1;";
	$query = mysqli_query($db_conn, $sql);

	// improvisasi, conditional
	$query = mysqli_fetch_array($query);

	// cek jika ada tambahan, jika tidak ada makan buat dari primary ke 1
	if (isset($query['id_anggota'])) {
		$id_anggota_tmp = $query['id_anggota'];
		$id_anggota_tmp++;
	} else {
		$id_anggota_tmp = 1;
		$id_anggota_tmp = str_pad($id_anggota_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
		$id_anggota_tmp = 'AG' . $id_anggota_tmp;
	}

?>

	<div class="container mt-5">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url(); ?>/index.php?p=anggota" class="text-decoration-none">Daftar Anggota</a></li>
				<li class="breadcrumb-item active" aria-current="page">Tambah Anggota</li>
			</ol>
		</nav>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h4 class="text-center">Tambah Data Anggota</h4>
					</div>
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="id_anggota">ID Anggota</label>
								<input type="text" class="form-control form-control-disable" name="id_anggota" value="<?php echo $id_anggota_tmp; ?>" id="id_anggota" readonly>
							</div>
							<div class="form-group">
								<label for="nama_lengkap">Nama Lengkap</label>
								<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan Nama Lengkap ..." required>
							</div>
							<div class="form-group">
								<label for="">Jenis Kelamin</label>
								<div class="form-check">
									<input class="form-check-input" value="L" type="radio" name="jenis_kelamin" id="jk_pria">
									<label class="form-check-label" for="jk_pria">
										Pria
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" value="W" type="radio" name="jenis_kelamin" id="jk_wanita">
									<label class="form-check-label" for="jk_wanita">
										Wanita
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat">Alamat</label>
								<textarea type="" class="form-control" name="alamat" id="alamat" placeholder="Masukkan Alamat ..."></textarea>
							</div>
							<label for="foto">Foto</label>
							<div class="custom-file">
								<label class="custom-file-label" for="foto">Pilih File</label>
								<input type="file" class="custom-file-input" name="foto" id="foto">
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
	$status_aktif	= 'T';

	if (!empty($file_foto)) {
		// Rename file foto. Contoh: foto-AG007.jpg
		$ext_file = pathinfo($file_foto, PATHINFO_EXTENSION);
		$file_foto_rename = 'foto-' . $id_anggota . '.' . $ext_file;

		$dir_images = './images/';
		$path_image = $dir_images . $file_foto_rename;
		$file_foto = $file_foto_rename; // untuk keperluan Query INSERT

		move_uploaded_file($_FILES['foto']['tmp_name'], $path_image);
	} else {
		$file_foto = '-';
	}

	// Query
	$sql = "INSERT INTO anggota 
				VALUES('{$id_anggota}', '{$nama_lengkap}', '{$jenis_kelamin}', 
						'{$alamat}', '{$file_foto}', '{$status_aktif}')";
	$query = mysqli_query($db_conn, $sql);

	// mengalihkan halaman
	echo "<script>alert('Data berhasil di tambahkan');</script>";
	echo "<meta http-equiv='refresh' content='0; url=index.php?p=anggota'>";
}
?>