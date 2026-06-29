<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class Bookings extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    public function index()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('bookings.*, services.nama as nama_paket, users.nama_lengkap as nama_pelanggan');
        $builder->join('services', 'services.id = bookings.service_id');
        $builder->join('users',    'users.id = bookings.user_id');
        $builder->whereIn('bookings.status', ['pending', 'confirmed', 'in_progress']);
        $builder->orderBy('bookings.id', 'DESC');

        $data = [
            'title'    => 'Kelola Pesanan Masuk',
            'bookings' => $builder->get()->getResultArray()
        ];

        return view('admin/bookings/index', $data);
    }

    public function confirm($id)
    {
        $this->bookingModel->save([
            'id'     => $id,
            'status' => 'confirmed'
        ]);

        session()->setFlashdata('pesan', 'Pesanan berhasil dikonfirmasi! Menunggu staff mengerjakan.');
        return redirect()->to('/admin/bookings');
    }

    public function cancel($id)
    {
        $this->bookingModel->save([
            'id'     => $id,
            'status' => 'cancelled'
        ]);

        session()->setFlashdata('pesan', 'Pesanan telah dibatalkan!');
        return redirect()->to('/admin/bookings');
    }

    public function history()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('bookings.*, services.nama as nama_paket, users.nama_lengkap as nama_pelanggan');
        $builder->join('services', 'services.id = bookings.service_id');
        $builder->join('users',    'users.id = bookings.user_id');
        $builder->whereIn('bookings.status', ['completed', 'cancelled']); 
        $builder->orderBy('bookings.id', 'DESC');

        $data = [
            'title'    => 'Riwayat Pesanan',
            'bookings' => $builder->get()->getResultArray()
        ];

        return view('admin/bookings/history', $data);
    }
}