<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Staff - Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('staff') ?>">Laundry Staff</a>
        <div class="d-flex">~
            <a href="<?= base_url('/logout') ?>" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="text-success">Selamat datang, <?= session()->get('nama'); ?>!</h2>

            <div class="mt-3">
                <a href="<?= base_url('staff/booking') ?>" class="btn btn-warning">
                    Lihat Tugas
                </a>
            </div>

            <p class="text-muted mt-3">
                Anda login sebagai: <strong><?= strtoupper(session()->get('role')); ?></strong>
            </p>

            <hr>

            <p>Halaman ini digunakan untuk mengelola pekerjaan laundry oleh staff.</p>
        </div>
    </div>
</div>

</body>
</html>