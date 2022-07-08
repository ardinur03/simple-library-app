<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Perpustakaan Ardidev'; ?></title>

    <!-- css botstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/bootstrap-4-3/css/bootstrap.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/style.css">

    <!-- css font-awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/fortawesome/font-awesome/css/all.css">
</head>

<body>
    <nav class=" navbar navbar-dark fixed-top bg-secondary-custom flex-md-nowrap p-2 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?= $_SITE_DESC_ADDRESS; ?>"><?= $_SITE_TITLE; ?></a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="<?= base_url('logout.php'); ?>">Sign out</a>
            </li>
        </ul>
    </nav>