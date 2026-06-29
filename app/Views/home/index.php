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
        <a class="navbar-brand" href="#">Laundry App</a>

        <div class="d-flex">
            <a href="<?= base_url('/login') ?>" class="btn btn-light btn-sm me-2">Login</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Daftar Layanan Laundry</h2>

    <div class="row">
        <?php foreach($services as $s) : ?>
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">

                <?php if($s['foto']) : ?>
                    <img src="<?= base_url('uploads/' . $s['foto']) ?>" 
                         class="card-img-top" 
                         style="height: 200px; object-fit: cover;">
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title"><?= $s['nama']; ?></h5>
                    <p class="card-text text-muted"><?= $s['deskripsi']; ?></p>

                    <h6 class="text-success">
                        Rp <?= number_format($s['harga'], 0, ',', '.'); ?> / kg
                    </h6>

                    <small>Durasi: <?= $s['durasi']; ?> menit</small>
                </div>

                <div class="card-footer text-center">
                    <a href="<?= base_url('/login') ?>" class="btn btn-success btn-sm">
                        Pesan (Login dulu)
                    </a>
                </div>

            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>