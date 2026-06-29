<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // 1. Mengambil data dari session login
        $data = [
            'nama' => session()->get('nama_lengkap'),
            'role' => session()->get('role')
        ];
        
        // 2. Mengirimkan variabel $data ke View
        return view('admin/dashboard', $data);
    }
}