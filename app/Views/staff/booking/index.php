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
            <a class="nav-link active" href="<?= base_url('staff/booking') ?>">Daftar Tugas</a>
            <a class="nav-link" href="<?= base_url('staff/booking/history') ?>">Riwayat Tugas</a>
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

    <?php if(session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Tugas Laundry</h2>
        <a href="<?= base_url('staff/booking/history') ?>" class="btn btn-secondary">
            Riwayat Tugas Saya
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
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($bookings)) : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada tugas tersedia.
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
                                <?php if($b['status'] == 'confirmed') : ?>
                                    <span class="badge bg-warning text-dark">Menunggu Diambil</span>
                                <?php elseif($b['status'] == 'in_progress') : ?>
                                    <span class="badge bg-primary">Sedang Dikerjakan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($b['status'] == 'confirmed') : ?>
                                    <!-- Tombol Ambil: hanya muncul jika belum ada yang klaim -->
                                    <a href="<?= base_url('staff/booking/take/' . $b['id']) ?>"
                                       class="btn btn-success btn-sm"
                                       onclick="return confirm('Ambil tugas ini?')">
                                        Ambil Tugas
                                    </a>

                                <?php elseif($b['status'] == 'in_progress' && $b['staff_id'] == session()->get('id')) : ?>
                                    <!-- Tombol Selesai: hanya muncul untuk staff yang mengklaim -->
                                    <a href="<?= base_url('staff/booking/complete/' . $b['id']) ?>"
                                       class="btn btn-primary btn-sm"
                                       onclick="return confirm('Tandai pesanan ini sebagai selesai?')">
                                        Selesaikan
                                    </a>

                                <?php else : ?>
                                    <!-- Dikerjakan staff lain -->
                                    <span class="text-muted small">Dikerjakan staff lain</span>
                                <?php endif; ?>
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