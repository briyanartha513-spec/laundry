<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4">Daftar Akun Laundry</h3>
                    <form action="<?= base_url('/register/save') ?>" method="post">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nomor Telepon</label>
                            <input type="text" name="telepon" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
                    </form>
                    <p class="text-center mt-3">Sudah punya akun? <a href="<?= base_url('/login') ?>">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>