<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class PaymentCallback extends BaseController
{
    public function index()
    {
        // 1. Ambil data kiriman mentah dari Midtrans
        $jsonStr = $this->request->getBody();
        $notification = json_decode($jsonStr, true);

        if (!$notification) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Payload kosong!']);
        }

        $orderId           = $notification['order_id']; // Contoh: LNDRY-52-1783386480
        $transactionStatus = $notification['transaction_status'];

        // 2. Cek jika status pembayaran sukses
        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            
            $db = \Config\Database::connect();
            
            // 🎯 TRIK 1: Pecah string 'LNDRY-52-1783386480' buat ngambil angka ID aslinya (52)
            $parts = explode('-', $orderId);
            $realId = isset($parts[1]) ? $parts[1] : $orderId;

            // Cari data transaksi berdasarkan ID asli berupa angka
            $booking = $db->table('bookings')->where('id', $realId)->get()->getRowArray();

            if ($booking) {
                // 🎯 TRIK 2: UPDATE DATABASE JADI LUNAS DULUAN (Biar aman tersimpan)
                $db->table('bookings')->where('id', $realId)->update(['status' => 'Lunas']);

                // Cari data user buat dapetin email pelanggan
                $user = $db->table('users')->where('id', $booking['user_id'])->get()->getRowArray();

                if ($user) {
                    $emailPelanggan = $user['email'];

                    // 🎯 TRIK 3: Bungkus proses email pake try-catch. 
                    // Biarpun SMTP Google diblokir WiFi, aplikasi GAK AKAN CRASH dan tetep return status 200 ke Midtrans!
                    try {
                        $this->kirimEmailNotifikasi($orderId, $emailPelanggan);
                    } catch (\Exception $e) {
                        log_message('error', 'Gagal kirim email akibat jaringan: ' . $e->getMessage());
                    }
                }
            }
        }

        // Wajib ngasih respon 200 ke Midtrans biar gak dikirimin email eror lagi
        return $this->response->setStatusCode(200)->setJSON(['message' => 'Callback berhasil diproses']);
    }

    private function kirimEmailNotifikasi($orderId, $customerEmail)
    {
        $email = \Config\Services::email();

        // Menggunakan email pengirim sesuai konfigurasi Email.php lu
        $email->setFrom('salvadino.hansyah@gmail.com', 'Laundry');
        $email->setTo($customerEmail); 
        $email->setSubject('Nota Pembayaran Laundry #' . $orderId);

        $pesan = "
            <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #e0e0e0; max-width: 600px;'>
                <h2 style='color: #198754;'>Pembayaran Sukses Ditandai!</h2>
                <p>Halo, terima kasih telah melakukan pembayaran untuk transaksi <strong>#{$orderId}</strong>.</p>
                <p>Status cucian Anda Selesai <strong>Silahkan Ambil</strong>.</p>
                <hr style='border: 0; border-top: 1px solid #eee;'>
                <p style='font-size: 12px; color: #777;'>Ini adalah email otomatis dari sistem payment gateway Midtrans.</p>
            </div>
        ";

        $email->setMessage($pesan);
        $email->send();
    }
}