<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Laundry Admin</a>
        <div class="d-flex">
            <a href="<?= base_url('/logout') ?>" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-primary">Selamat datang, <?= $nama; ?>!</h2>
                    <div style="margin-top: 20px;">
                         <a href="/admin/services" class="btn btn-primary">Kelola Layanan</a>
                         <a href="/admin/bookings" class="btn btn-success">Kelola Pesanan</a>
</div>
                    <p class="text-muted">Anda login sebagai: <strong><?= strtoupper($role); ?></strong></p>
                    <hr>
                    <p>Ini adalah halaman Dashboard khusus Admin. Nanti kita akan tambahkan fitur kelola layanan dan kelola booking di sini.</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>