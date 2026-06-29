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
            <a class="nav-link" href="<?= base_url('/admin/bookings') ?>">Pesanan</a>
        </div>
        <div class="d-flex">
            <a href="<?= base_url('/logout') ?>" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Layanan Laundry</h2>
        <a href="<?= base_url('/admin/services/create') ?>" class="btn btn-primary">+ Tambah Layanan</a> 
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Layanan</th>
                        <th>Harga</th>
                        <th>Durasi (Menit)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($services)) : ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data layanan.</td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1; foreach($services as $s) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td>
                                <?= $s['foto'] ? '<img src="'.base_url('uploads/'.$s['foto']).'" width="50">' : 'Tidak ada foto' ?>
                            </td>
                            <td><?= $s['nama']; ?></td>
                            <td>Rp <?= number_format($s['harga'], 0, ',', '.'); ?></td>
                            <td><?= $s['durasi']; ?></td>
                            <td>
                                <a href="<?= base_url('/admin/services/edit/' . $s['id']) ?>" 
                                class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('/admin/services/delete/' . $s['id']) ?>" 
                                        class="btn btn-danger btn-sm" 
                                     onclick="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>