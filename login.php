<?php
include './config/konfigurasi-umum.php';
include './config/koneksi-db.php';
include 'helpers/helper_umum.php';

session_start();
if (isset($_SESSION['status']) == 'login') {
	echo "<script>window.location='" . base_url() . "';</script>";
}

if (!isset($_POST['kirim'])) {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= isset($title) ? $title : 'Perpustakaan Ardidev'; ?></title>

		<link rel="stylesheet" href="<?= base_url(); ?>/vendor/bootstrap-4-3/css/bootstrap.min.css">
	</head>

	<main id="authentication-login">
		<div class="container">
			<div class="row vh-100 align-items-center justify-content-center">
				<div class="col-5">
					<h2 class="text-center mb-4">Admin Perpustakaan</h2>
					<div class="card">
						<div class="card-body">
							<h2 class="card-title text-center">Login</h2>
							<hr>
							<form action="" method="post">
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label for="input-username">Username</label>
											<input type="text" required class="form-control" name="username" value="" id="input-username" placeholder="Masukkan Usename ...">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label for="input-password">Password</label>
											<input type="password" required class="form-control" name="password" id="input-password" placeholder="Masukkan Password ...">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<input type="submit" name="kirim" class="btn btn-block btn-primary" value="Log in">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

<?php
} else {

	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$userpass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);



	$sql = "SELECT * FROM admin WHERE username = '{$username}'";
	$query = mysqli_query($db_conn, $sql);

	$data = mysqli_fetch_array($query);

	// jika user terdaftar
	if ($query->num_rows > 0) {
		// verifikasi password
		if (password_verify($userpass, $data["password"])) {
			// buat Session
			// session_start();
			$_SESSION['id_admin'] = $data['id_admin'];
			$_SESSION['username'] = $data['username'];
			$_SESSION['nama_lengkap'] = $data['nama_lengkap'];
			$_SESSION['status'] = "login";

			echo "<script>alert('Login Berhasil!');</script>";
			echo "<meta http-equiv='refresh' content='0; url=index.php'>";
		} else {
			echo "<script>alert('Login Gagal!');</script>";
			echo "<meta http-equiv='refresh' content='0; url=login.php'>";
		}
	} else {
		echo "<script>alert('Login Gagal!');</script>";
		echo "<meta http-equiv='refresh' content='0; url=login.php'>";
	}
}
include './app/layout/script.php';

?>