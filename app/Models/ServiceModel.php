<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table            = 'services'; // Nama tabel di database
    protected $primaryKey       = 'id';
    
    // Kolom-kolom yang diizinkan untuk diisi sesuai spesifikasi
    protected $allowedFields    = ['nama', 'deskripsi', 'harga', 'durasi', 'foto'];
    
    // Mengaktifkan fitur otomatis pengisian kolom created_at dan updated_at (opsional tapi disarankan)
    protected $useTimestamps    = true; 
}