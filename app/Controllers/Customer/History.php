<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;

class History extends BaseController
{
    public function index()
    {
        // Memanggil model Booking
        $bookingModel = new \App\Models\BookingModel();
        
        // Mengambil semua data pesanan dari database dan menyimpannya ke dalam array 'bookings'
        $data['bookings'] = $bookingModel->findAll(); 

        // Mengirimkan variabel $data ke halaman view
        return view('customer/history', $data); 
    }
}