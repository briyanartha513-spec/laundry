<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Login Laundry</h4>
                </div>
                <div class="card-body">
                    
                    <?php if(session()->getFlashdata('error')):?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif;?>

                    <form action="<?= base_url('/login/process') ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" id="email" required placeholder="Masukkan email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required placeholder="Masukkan password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>
                        <div class="d-flex justify-content-between mt-2">
                            <a href="<?= base_url('/forgot-password') ?>" class="text-decoration-none text-muted small">
                                Lupa Password?
                            </a>    
                            <a href="<?= base_url('/register') ?>" class="text-decoration-none text-primary small fw-bold">
                                Belum punya akun? Daftar
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>