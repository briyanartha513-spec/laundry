<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table      = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'booking_id', 'pesan', 'is_read', 'created_at'
    ];
    protected $useTimestamps = false; // kita handle manual
}