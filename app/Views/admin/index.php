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
            <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">Admin Dashboard</a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="<?= base_url('admin/services') ?>">Kelola Layanan</a>
                <a class="nav-link active" href="<?= base_url('admin/bookings') ?>">Pesanan Aktif</a>
                <a class="nav-link" href="<?= base_url('admin/bookings/history') ?>">Riwayat</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Pesanan Laundry Aktif</h2>

        <?php if(session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No ID</th>
                            <th>Layanan</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($bookings)) : ?>
                            <?php foreach($bookings as $b) : ?>
                            <tr>
                                <td>#<?= $b['id'] ?></td>
                                <td><?= $b['nama_layanan'] ?></td>
                                <td>Rp <?= number_format($b['total_harga'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge bg-<?= ($b['status'] == 'pending') ? 'warning text-dark' : 'info' ?>">
                                        <?= strtoupper($b['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($b['status'] == 'pending') : ?>
                                        <a href="<?= base_url('admin/bookings/confirm/' . $b['id']) ?>" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi pesanan ini dan mulai proses cucian?');">Terima & Proses</a>
                                        
                                        <a href="<?= base_url('admin/bookings/cancel/' . $b['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan pesanan ini?');">Tolak</a>
                                    <?php elseif($b['status'] == 'diproses') : ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Sedang Dikerjakan</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada pesanan aktif saat ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>