<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">Laundry Customer</a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="<?= base_url('/customer/booking') ?>">Pesan Laundry</a>
                <a class="nav-link" href="<?= base_url('/customer/history') ?>">Riwayat Pesanan</a>
            </div>
            <div class="d-flex">
                <a href="<?= base_url('/logout') ?>" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>
    <?= $this->renderSection('content') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>