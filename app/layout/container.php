<main role="main" class="col-md-10 ml-sm-auto col-lg-10 py-4">
    <?php
    /* Menentukkan halaman berdasarkan menu yang dipilih */
    $app_dir = 'app';

    $p = ''; // variable untuk menentukkan halaman yang dituju
    if (isset($_GET['p'])) { // memeriksa variable
        $p = $_GET['p'];
    }

    /* Lakukan include file *.php sesuai halaman yang dituju */
    if (!empty($p)) {
        $file = $app_dir . '/' . $p . '.php';

        if (file_exists($file)) { // memeriksa apakah file *.php tersedia?
            include $file;
        } else {
            include $app_dir . '/404.php';
        }
    } else {
        include $app_dir . '/beranda.php';
    }
    ?>
</main>
</div> <!-- penutup side bar -->