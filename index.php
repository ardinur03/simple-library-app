<?php

include 'config/koneksi-db.php';

include 'config/konfigurasi-umum.php';

include 'helpers/helper_umum.php';

session_start();

if (isset($_SESSION['status']) != 'login') {
	echo "<script>window.location='" . base_url('login.php') . "';</script>";
} else {
	include './app/layout/header.php';
	include './app/layout/sidebar-menu.php';

	include 'app/layout/container.php';

	include 'app/layout/footer.php';
	include 'app/layout/script.php';
}
