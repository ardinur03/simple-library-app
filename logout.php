<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (isset($_SESSION)) {
	session_destroy();
}

echo "<meta http-equiv='refresh' content='0; url=login.php'>";
echo "<script>alert('Anda Berhasil Logout !');</script>";
