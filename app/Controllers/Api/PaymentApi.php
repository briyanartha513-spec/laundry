<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentApi extends BaseController
{
    public function get_token($id)
    {
        $db = \Config\Database::connect();
        
        $booking = $db->table('bookings')->where('id', $id)->get()->getRowArray();

        if (!$booking) {
            return $this->response->setJSON(['error' => 'Booking tidak ditemukan']);
        }
        $total = (int)($booking['total_harga'] ?? 0);

        // --- KONFIGURASI MIDTRANS ---
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

        try {
            $previousError = error_reporting(E_ERROR | E_PARSE);
            
            $cacheKey = 'snap_token_booking_' . $id;
            $snapToken = null;

            try {
                $snapToken = cache($cacheKey); 
            } catch (\Exception $e) {
                $snapToken = null; 
            }

            if (!$snapToken) {
                $snapToken = Snap::getSnapToken($params);
                
                if ($snapToken) {
                    try {
                        cache()->save($cacheKey, $snapToken, 600);
                    } catch (\Exception $e) {}
                }
            }

            error_reporting($previousError); 

            return $this->response->setJSON(['token' => $snapToken]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 500,
                'message' => 'Penyakit Asli Midtrans: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}