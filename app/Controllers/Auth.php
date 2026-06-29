<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // Menampilkan halaman login
        return view('auth/login');
    }

    public function process()
    {
        $session = session();
        $model = new UserModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        // Cari user berdasarkan email
        $user = $model->where('email', $email)->first();
        
        if ($user) {
            // Cek kecocokan password
            $verify_pass = password_verify($password, $user['password']);
            if ($verify_pass) {
                // Jika password benar, simpan data ke session
                $ses_data = [
                    'id'            => $user['id'],
                    'nama_lengkap'  => $user['nama_lengkap'],
                    'email'         => $user['email'],
                    'role'          => $user['role'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                
               // Arahkan ke dashboard masing-masing role
                if ($user['role'] == 'admin') return redirect()->to('/admin/dashboard');
                elseif ($user['role'] == 'staff') return redirect()->to('/staff/dashboard');
                else return redirect()->to('/customer/booking');
                
            } else {
                $session->setFlashdata('error', 'Password yang Anda masukkan salah!');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Email tidak ditemukan!');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}