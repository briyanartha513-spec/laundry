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
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white mt-2">
                    <h4 class="mb-0">Edit Layanan</h4>
                </div>
                <div class="card-body">
                    
                    <form action="<?= base_url('/admin/services/update/' . $service['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="fotoLama" value="<?= $service['foto']; ?>">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Layanan</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $service['nama']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $service['deskripsi']; ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" id="harga" name="harga" value="<?= $service['harga']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="durasi" class="form-label">Durasi (Menit)</label>
                                <input type="number" class="form-control" id="durasi" name="durasi" value="<?= $service['durasi']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Ganti Foto (Kosongkan jika tidak diubah)</label>
                            <div class="mb-2">
                                <small>Foto saat ini:</small><br>
                                <img src="<?= base_url('uploads/' . $service['foto']); ?>" width="100" class="img-thumbnail">
                            </div>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('/admin/services') ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning text-white">Update Layanan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>