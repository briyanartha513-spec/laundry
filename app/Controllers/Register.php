<?php

namespace App\Controllers;

use App\Models\UserModel; // Pastikan Anda sudah punya UserModel

class Register extends BaseController
{
    public function index()
    {
        return view('auth/register');
    }

    public function save()
    {
        $userModel = new \App\Models\UserModel();

        // Ambil data dari form
        $userModel->save([
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'telepon'      => $this->request->getPost('telepon'),
            'role'         => 'customer' // Otomatis jadi customer
        ]);

        session()->setFlashdata('pesan', 'Registrasi berhasil! Silakan Login.');
        return redirect()->to('/login');
    }
}