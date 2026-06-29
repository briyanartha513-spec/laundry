<?php

namespace App\Controllers;

use Midtrans\Config;
use Midtrans\Snap;

class Pembayaran extends BaseController
{
    public function get_token($id)
    {
        $db = \Config\Database::connect();
        
        $booking = $db->table('bookings')->where('id', $id)->get()->getRowArray();

        if (!$booking) {
            return $this->response->setJSON(['error' => 'Booking tidak ditemukan']);
        }

        $total = (int)($booking['total_harga'] ?? 0);

        Config::$serverKey = 'Mid-server-2m9CeTecsQFOYc0GSvME_u7G';
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
        Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_CAINFO => false,
                CURLOPT_CAPATH => false,
        ];

        $params = [
            'transaction_details' => [
                'order_id' => 'LNDRY-' . $id . '-' . time(),
                'gross_amount' => $total,
            ],
            'item_details' => [
                [
                    'id'       => 'ITEM-' . $id,
                    'price'    => $total,
                    'quantity' => 1,
                    'name'     => 'Laundry #' . $id,
                ]
            ],
        ];

        // <-- INI BAGIAN YANG DIGANTI, mulai dari sini
        try {
            // Matikan warning sementara sebelum hit Midtrans
            $previousError = error_reporting(E_ERROR | E_PARSE);
            $snapToken = Snap::getSnapToken($params);
            error_reporting($previousError); // kembalikan seperti semula

            return $this->response->setJSON(['token' => $snapToken]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Midtrans Error: ' . $e->getMessage()]);
        }
        // <-- sampai sini
    }
}