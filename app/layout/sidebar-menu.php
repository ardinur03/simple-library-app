<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">

            <div class="">
                <ul class="nav flex-column mt-3">
                    <h6 class=" d-flex justify-content-center align-items-center py-2 mx-2 mb-1 text-muted">
                        <span>Hi, <?= $_SESSION['nama_lengkap']; ?></span>
                    </h6>
                    <li class="nav-item <?= $_GET['p'] == '' ? 'active-nav' : ''; ?>">
                        <a class="nav-link " href="index.php">
                            Beranda
                        </a>
                    </li>
                    <h6 class="d-flex justify-content-between bg-secondary-custom align-items-center py-3 mx-0 mb-1 text-muted">
                        <span class="ml-2 text-white">Data Master</span>
                    </h6>
                    <li class="nav-item <?= $_GET['p'] == 'anggota' ? 'active-nav' : ''; ?>">
                        <a class="nav-link" href="index.php?p=anggota">
                            Data Anggota
                        </a>
                    </li>
                    <li class="nav-item <?= $_GET['p'] == 'buku' ? 'active-nav' : ''; ?>">
                        <a class="nav-link" href="index.php?p=buku">
                            Data Buku
                        </a>
                    </li>
                    <li class="nav-item <?= $_GET['p'] == 'kategori' ? 'active-nav' : ''; ?>">
                        <a class="nav-link" href="index.php?p=kategori">
                            Data Kategori
                        </a>
                    </li>
                    <li class="nav-item <?= $_GET['p'] == 'penulis' ? 'active-nav' : ''; ?>">
                        <a class="nav-link" href="index.php?p=penulis">
                            Data Penulis
                        </a>
                    </li>
                    <li class="nav-item <?= $_GET['p'] == 'penerbit' ? 'active-nav' : ''; ?>">
                        <a class="nav-link" href="index.php?p=penerbit">
                            Data Penerbit
                        </a>
                    </li>
                    <h6 class="d-flex justify-content-between bg-secondary-custom align-items-center py-3 mx-0 mb-1 text-muted">
                        <span class="ml-2 text-white">Data Transaksi</span>
                    </h6>
                    <li class="nav-item <?= $_GET['p'] == 'peminjaman' ? 'active-nav' : ''; ?>">
                        <a class="nav-link" href="index.php?p=peminjaman">
                            Transaksi Peminjaman
                        </a>
                    </li>
                    <li class="nav-item <?= $_GET['p'] == 'pengembalian' ? 'active-nav' : ''; ?>">
                        <a class="nav-link" href="index.php?p=pengembalian">
                            Transaksi Pengembalian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="logout.php">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>