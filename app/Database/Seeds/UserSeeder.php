<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_lengkap' => 'Administrator Laundry',
                'email'        => 'admin@gmail.com',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'role'         => 'admin',
                'telepon'      => '08123456789',
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lengkap' => 'Staff Cuci',
                'email'        => 'staff@gmail.com',
                'password'     => password_hash('staff123', PASSWORD_DEFAULT),
                'role'         => 'staff',
                'telepon'      => '08123456780',
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lengkap' => 'Budi Pelanggan',
                'email'        => 'budi@gmail.com',
                'password'     => password_hash('budi123', PASSWORD_DEFAULT),
                'role'         => 'customer',
                'telepon'      => '08123456781',
                'created_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        // Memasukkan data ke tabel users
        $this->db->table('users')->insertBatch($data);
    }
}