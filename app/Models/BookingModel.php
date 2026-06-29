<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'service_id', 'tanggal_booking', 'catatan', 'status', 'berat', 'total_harga', 'staff_id', 'started_at', 'completed_at'];

    // Aktifkan otomatisasi tanggal
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}