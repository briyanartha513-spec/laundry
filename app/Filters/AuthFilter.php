<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah user sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek apakah role user sesuai dengan role yang diizinkan di Routes
        if ($arguments && session()->get('role') !== $arguments[0]) {
            // Jika pelanggan mencoba masuk ke halaman admin/staff, kembalikan ke tempat asalnya
            return redirect()->back()->with('error', 'Akses ditolak! Anda bukan ' . $arguments[0]); 
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi
    }
}