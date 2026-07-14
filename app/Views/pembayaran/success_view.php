<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-5 text-center shadow-sm" style="max-width: 500px; border-radius: 15px; background: #ffffff;">
            
            <div class="text-success mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            
            <h2 class="fw-bold text-dark">Pembayaran Sukses!</h2>
            <p class="text-muted">Terima kasih, pembayaran untuk Transaksi ID <strong>#<?= esc($order_id) ?></strong> telah kami terima secara otomatis oleh sistem.</p>
            <p class="small text-secondary">Status Tagihan laundry Anda sekarang lunas. Silakan cek inbox/spam email Anda untuk melihat e-receipt.</p>
            
            <hr class="my-4">
            
            <a href="<?= base_url('customer/history') ?>" class="btn btn-success px-4 py-2 w-100" style="border-radius: 8px; font-weight: 600;">
                Lihat Riwayat Transaksi
            </a>
            
        </div>
    </div>

</body>
</html>