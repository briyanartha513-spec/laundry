<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('staff/dashboard') ?>">Laundry Staff</a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="<?= base_url('staff/booking') ?>">Daftar Tugas</a>
            <a class="nav-link active" href="<?= base_url('staff/booking/history') ?>">Riwayat Tugas</a>
        </div>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">
                Halo, <?= session()->get('nama') ?>!
            </span>
            <a href="<?= base_url('/logout') ?>" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <?php if(session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('pesan') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Riwayat Tugas Saya</h2>
        <a href="<?= base_url('staff/booking') ?>" class="btn btn-success">
            ← Kembali ke Daftar Tugas
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Paket</th>
                        <th>Tgl Booking</th>
                        <th>Total Harga</th>
                        <th>Mulai Dikerjakan</th>
                        <th>Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($bookings)) : ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada riwayat tugas.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1; foreach($bookings as $b) : ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><strong><?= $b['nama_pelanggan'] ?></strong></td>
                            <td><?= $b['nama_paket'] ?></td>
                            <td><?= date('d M Y', strtotime($b['tanggal_booking'])) ?></td>
                            <td>Rp <?= number_format($b['total_harga'], 0, ',', '.') ?></td>
                            <td>
                                <?= !empty($b['started_at']) 
                                    ? date('d M Y H:i', strtotime($b['started_at'])) 
                                    : '<span class="text-muted">-</span>' ?>
                            </td>
                            <td>
                                <?= !empty($b['completed_at']) 
                                    ? date('d M Y H:i', strtotime($b['completed_at'])) 
                                    : '<span class="text-muted">-</span>' ?>
                            </td>
                            <td>
                                <span class="badge bg-success">Selesai</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>