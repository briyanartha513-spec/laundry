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
            <a class="nav-link" href="<?= base_url('/admin/services') ?>">Layanan</a>
            <a class="nav-link active" href="<?= base_url('/admin/bookings') ?>">Pesanan</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Kelola Pesanan (Booking)</h2>
        <a href="<?= base_url('admin/bookings/history') ?>" class="btn btn-secondary">
            Lihat Riwayat Pesanan
        </a>
        </div>
   <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Tgl Booking</th>
                        <th>Total Harga</th>
                        <th>Status</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($bookings)) : ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pesanan masuk.</td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1; foreach($bookings as $b) : ?>
                       <tr>
                            <td><?= $i++; ?></td>
                            <td><strong><?= $b['nama_pelanggan']; ?></strong></td>
                            <td><?= $b['nama_paket']; ?></td>
                            <td>
                                 <?= (!empty($b['tanggal_booking']) && $b['tanggal_booking'] != '0000-00-00 00:00:00') 
                                    ? date('d M Y', strtotime($b['tanggal_booking'])) 
                                    : '<span class="text-muted">-</span>'; 
                                 ?>
                            </td>
                            <td>Rp <?= number_format($b['total_harga'], 0, ',', '.'); ?></td>
                            <td>
                                <?php if($b['status'] == 'pending') : ?>
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                <?php elseif($b['status'] == 'confirmed') : ?>
                                    <span class="badge bg-success">Dikonfirmasi</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary"><?= $b['status']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                 <?php if($b['status'] == 'pending') : ?>
                                     <a href="<?= base_url('/admin/bookings/confirm/' . $b['id']) ?>"
                                         class="btn btn-primary btn-sm">Konfirmasi</a>
                                     <a href="<?= base_url('/admin/bookings/cancel/' . $b['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                         onclick="return confirm('Yakin ingin menolak pesanan ini?')">Tolak</a>
                                 <?php else : ?>
                                      <button class="btn btn-outline-secondary btn-sm" disabled>Selesai</button>
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

</body>
</html>