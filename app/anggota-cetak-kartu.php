<?php

require_once '../vendor/autoload.php';
include '../helpers/helper_umum.php';
include '../config/koneksi-db.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', TRUE);

if (isset($_GET['id'])) { // memperoleh anggota_id
	$id_anggota = $_GET['id'];

	if (!empty($id_anggota)) {
		// Query
		$sql = "SELECT * FROM anggota WHERE id_anggota = '{$id_anggota}';";
		$query = mysqli_query($db_conn, $sql);
		$row = $query->num_rows;
?>

		<!DOCTYPE html>
		<html lang="en">

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Cetak Kartu Anggota</title>
			<style>
				* {
					margin: 0;
					font-family: Arial, Helvetica, sans-serif;
				}

				h3 {
					text-align: center;
					margin: 15px;
					text-decoration: underline;
				}

				section#member-card {
					text-align: left;
				}

				#member-card {
					border-radius: 10px;
					padding: 5px;
					margin: 0 auto;
					width: 450px;
				}

				#member-photo {
					float: left;
					width: 120px;
					margin-right: 10px;
				}

				#member-data {
					float: left;
					width: 320px;
				}
			</style>
		</head>

		<body>
			<?php
			if ($row > 0) {
				$data = mysqli_fetch_array($query); // memperoleh data anggota

				$data_foto = $data['foto'];
				if ($data_foto == '-') {
					$data_foto = 'foto-default.jpg';
				}
			?>
				<section id="member-card">
					<h3>Kartu Anggota</h3>

					<div id="member-photo">
						<img src="<?= base_url('/images/') . $data_foto; ?>" width="120">
					</div>
					<div id="member-data">
						<table>
							<tr>
								<th>Id Anggota</th>
								<th>:</th>
								<th> <?php echo $data['id_anggota']; ?></th>
							</tr>
							<tr>
								<th>Nama Lengkap</th>
								<th>:</th>
								<th><?php echo $data['nama_lengkap']; ?></th>
							</tr>
							<tr>
								<th>Jenis Kelamin</th>
								<th>:</th>
								<th><?php echo ($data['jenis_kelamin'] == 'L') ? 'Pria' : 'Wanita'; ?></th>
							</tr>
							<tr>
								<th>Alamat</th>
								<th>:</th>
								<th><?php echo $data['alamat']; ?></th>
							</tr>
						</table>
					</div>
				</section>
			<?php
			}
			?>
		</body>

		</html>

<?php
	}
}
?>

<?php
$html = ob_get_clean();
$dompdf->load_html($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("kartu-anggota-perpus.pdf");
?>