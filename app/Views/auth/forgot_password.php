<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow text-center">
                <div class="card-body py-5">
                    <h3 class="mb-3 text-warning">Oops, Lupa Password?</h3>
                    <p class="mb-4">Untuk keamanan akun Anda, silakan hubungi Admin Laundry via WhatsApp untuk melakukan reset password.</p>
                    <a href="https://wa.me/6281381308579" target="_blank" class="btn btn-success mb-3 w-100">
                        Hubungi Admin (WhatsApp)
                    </a>
                    <a href="<?= base_url('/login') ?>" class="text-decoration-none">Kembali ke halaman Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>