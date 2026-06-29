<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">Laundry Customer</a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="<?= base_url('/customer/booking') ?>">Pesan Laundry</a>
                <a class="nav-link active" href="<?= base_url('/customer/history') ?>">Riwayat Pesanan</a>
            </div>
            <div class="d-flex">
                <a href="<?= base_url('/logout') ?>" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Riwayat Pesanan Saya</h2>

        <?php if(session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
<tbody>
    <?php if(!empty($bookings)) : ?>
        <?php $i = 1; foreach($bookings as $b) : ?>
        <tr>
            <td><?= $i++ ?></td>
            <td>Rp <?= number_format($b['total_harga'], 0, ',', '.') ?></td>
            <td>
                <?php 
                $warna = 'dark'; $teks = $b['status'];
                if ($b['status'] == 'pending') { $warna = 'warning'; $teks = 'Pending'; }
                elseif ($b['status'] == 'diproses') { $warna = 'info'; $teks = 'Diproses'; }
                elseif ($b['status'] == 'completed' || $b['status'] == 'selesai') { $warna = 'success'; $teks = 'Selesai'; }
                elseif ($b['status'] == 'cancelled') { $warna = 'danger'; $teks = 'Dibatalkan'; }
                ?>
                <span class="badge bg-<?= $warna ?>"><?= $teks ?></span>
            </td>
            <td>
                <?php if($b['status'] == 'completed' || $b['status'] == 'selesai') : ?>
                    <button class="btn btn-success btn-sm pay-button" data-id="<?= $b['id'] ?>">Ambil Pesanan</button>
                <?php elseif($b['status'] == 'pending') : ?>
                    <a href="<?= base_url('customer/booking/edit/' . $b['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('customer/booking/delete/' . $b['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?');">Hapus</a>
                <?php else: ?>
                    <button class="btn btn-secondary btn-sm" disabled>Tunggu</button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr><td colspan="4" class="text-center">Belum ada pesanan.</td></tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-0z2G332IawD46hwy"></script>

<script>
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('pay-button')) {
        const id = e.target.getAttribute('data-id');
        
        fetch('<?= site_url('pembayaran/get_token/') ?>' + id)
        .then(res => res.json())
        .then(data => {
            if(data.token) {
                window.snap.pay(data.token, {
                    onSuccess: function() { 
                        window.location.href = '<?= site_url('pembayaran/success/') ?>' + id; 
                    }
                });
            } else {
                alert("Error: " + (data.error || "Gagal ambil token"));
            }
        })
        .catch(err => { alert("Error Server!"); });
    }
});
</script>
</body>
</html>