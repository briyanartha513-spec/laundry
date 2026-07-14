<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class BookingApi extends BaseController
{
    public function status($id = null)
    {
        // Gak perlu ngecek IF API KEY lagi di sini! Sudah di-filter duluan!
        
        $bookingModel = new BookingModel();
        $booking = $bookingModel->find($id);

        if (!$booking) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => 'Data booking laundry tidak ada.'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'status'  => 200,
            'data'    => $booking
        ])->setStatusCode(200);
    }
}