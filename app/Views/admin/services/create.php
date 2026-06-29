<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/admin/dashboard') ?>">Laundry Admin</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="<?= base_url('/admin/dashboard') ?>">Dashboard</a>
            <a class="nav-link active" href="<?= base_url('/admin/services') ?>">Layanan</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white mt-2">
                    <h4 class="mb-0">Tambah Layanan Baru</h4>
                </div>
                <div class="card-body">
                    
                    <form action="<?= base_url('/admin/services/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Layanan</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Cuci Kering Setrika" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan detail layanan..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" id="harga" name="harga" placeholder="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="durasi" class="form-label">Durasi (Menit)</label>
                                <input type="number" class="form-control" id="durasi" name="durasi" placeholder="60" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Layanan</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            <small class="text-muted">Format: jpg/png, Max: 2MB</small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('/admin/services') ?>" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Layanan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>