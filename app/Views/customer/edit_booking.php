<?= $this->extend('layouts/main') ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <h2>Edit Pesanan Layanan Laundry</h2>
    <div class="card shadow-sm mt-3" style="max-width: 500px;">
        <div class="card-body">
            <form action="<?= base_url('/customer/booking/update/' . $booking['id']) ?>" method="post">
                
                <div class="mb-3">
                    <label class="form-label">Pilih Layanan Baru:</label>
                    
                    <?php foreach($services as $s) : ?>
                        <div class="form-check border rounded p-3 mb-2">
                            <input class="form-check-input ms-1" type="radio" name="service_id" value="<?= $s['id'] ?>" id="layanan_<?= $s['id'] ?>" <?= ($booking['service_id'] == $s['id']) ? 'checked' : '' ?> required>
                            <label class="form-check-label ms-4 d-block" for="layanan_<?= $s['id'] ?>">
                                <strong><?= $s['nama'] ?></strong><br>
                                <span class="text-success">Rp <?= number_format($s['harga'], 0, ',', '.') ?> / kg</span><br>
                                <small class="text-muted">Durasi: <?= $s['durasi'] ?> Menit</small>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                <a href="<?= base_url('/customer/history') ?>" class="btn btn-secondary w-100 mt-2">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>