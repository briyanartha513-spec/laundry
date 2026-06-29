<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">Laundry Customer</a>
        <div class="navbar-nav me-auto">
    <a class="nav-link active" href="<?= base_url('/customer/booking') ?>">Pesan Laundry</a>
    <a class="nav-link" href="<?= base_url('/customer/history') ?>">Riwayat Pesanan</a>
</div>
<div class="d-flex">
    <a href="<?= base_url('/logout') ?>" class="btn btn-danger btn-sm">Logout</a>
</div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">Pilih Layanan Laundry</h2>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/customer/booking/save') ?>" method="post">
        <?= csrf_field(); ?>
        
        <div class="row">
            <?php foreach($services as $s) : ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <?php if($s['foto']) : ?>
                        <img src="<?= base_url('uploads/' . $s['foto']) ?>" class="card-img-top" alt="Foto Layanan" style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $s['nama']; ?></h5>
                        <p class="card-text text-muted"><?= $s['deskripsi']; ?></p>
                        <h6 class="text-success">Rp <?= number_format($s['harga'], 0, ',', '.'); ?> / kg</h6>
                        <small class="d-block mb-3">Durasi: <?= $s['durasi']; ?> Menit</small>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="service_id" id="service_<?= $s['id']; ?>" value="<?= $s['id']; ?>" required>
                            <label class="form-check-label" for="service_<?= $s['id']; ?>">
                                Pilih Layanan Ini
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Detail Pesanan</h5>
                <div class="mb-3">
                    <label for="berat" class="form-label">Perkiraan Berat (Kg)</label>
                    <input type="number" step="0.1" class="form-control" id="berat" name="berat" placeholder="Contoh: 2.5" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Buat Pesanan</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>