<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\NotificationModel;
use Dompdf\Dompdf;

class Booking extends BaseController
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

        $builder->select('
            bookings.*,
            services.nama      AS nama_paket,
            services.harga     AS harga_satuan,
            users.nama_lengkap AS nama_pelanggan,
            users.id           AS id_pelanggan
        ');
        $builder->join('services', 'services.id = bookings.service_id');
        $builder->join('users',    'users.id    = bookings.user_id');

        // Tampilkan semua confirmed (belum diambil) + in_progress milik staff ini
        $builder->groupStart()
                    ->where('bookings.status', 'confirmed')  
                    ->orGroupStart()
                        ->where('bookings.status',   'in_progress') 
                        ->where('bookings.staff_id', session()->get('id'))
                    ->groupEnd()
                ->groupEnd();

        $builder->orderBy('bookings.id', 'DESC');

        $data = [
            'title'    => 'Daftar Tugas Laundry',
            'bookings' => $builder->get()->getResultArray()
        ];

        return view('staff/booking/index', $data);
    }

    public function take($id)
    {
        $booking = $this->bookingModel->find($id);

        // Validasi: hanya bisa ambil jika statusnya 'confirmed'
        if (!$booking || $booking['status'] !== 'confirmed') {
            return redirect()->to('/staff/booking')
                ->with('error', 'Pesanan tidak tersedia atau sudah diambil staff lain.');
        }

        // Validasi: pastikan belum diklaim staff lain
        if (!empty($booking['staff_id'])) {
            return redirect()->to('/staff/booking')
                ->with('error', 'Pesanan ini sudah diklaim oleh staff lain.');
        }

        $this->bookingModel->save([
            'id'         => $id,
            'staff_id'   => session()->get('id'),
            'status'     => 'in_progress',          
            'started_at' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('pesan', 'Berhasil! Pesanan sudah Anda ambil. Silakan kerjakan.');
        return redirect()->to('/staff/booking');
    }

    public function complete($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('
            bookings.*,
            users.nama_lengkap AS nama_pelanggan,
            users.email,
            users.id AS id_pelanggan,
            services.nama AS nama_paket
        ');        
        $builder->join('services', 'services.id = bookings.service_id');
        $builder->join('users',    'users.id    = bookings.user_id');
        $builder->where('bookings.id', $id);
        $booking = $builder->get()->getRowArray();

        // Validasi: hanya staff yang mengklaim yang bisa menyelesaikan
        if (!$booking || $booking['staff_id'] != session()->get('id')) {
            return redirect()->to('/staff/booking')
                ->with('error', 'Anda tidak berhak menyelesaikan pesanan ini.');
        }

        // Validasi: hanya bisa diselesaikan jika statusnya 'in_progress'
        if ($booking['status'] !== 'in_progress') {
            return redirect()->to('/staff/booking')
                ->with('error', 'Status pesanan tidak valid untuk diselesaikan.');
        }

        // 1. Update status booking menjadi 'completed'
        $this->bookingModel->save([
            'id'           => $id,
            'status'       => 'completed',          
            'completed_at' => date('Y-m-d H:i:s'),
        ]);

        $notificationModel = new NotificationModel();

        // 2. Kirim notifikasi ke semua ADMIN
        $adminUsers = $db->table('users')
                         ->where('role', 'admin')
                         ->get()
                         ->getResultArray();

        foreach ($adminUsers as $admin) {
            $notificationModel->insert([
                'user_id'    => $admin['id'],
                'booking_id' => $id,
                'pesan'      => "Pesanan #{$id} atas nama {$booking['nama_pelanggan']} ({$booking['nama_paket']}) " .
                                "telah SELESAI dikerjakan oleh staff pada " . date('d/m/Y H:i') . ".",
                'is_read'    => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
        session()->setFlashdata('pesan', 'Pesanan berhasil diselesaikan! Notifikasi dikirim ke Admin dan Pelanggan.');
        
        // Notifikasi customer
        $notificationModel->insert([
            'user_id'    => $booking['id_pelanggan'],
            'booking_id' => $id,
            'pesan'      => "Hore! Cucian Anda ({$booking['nama_paket']}) telah selesai diproses.",
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Generate PDF
        $html = view('pdf/invoice', [
            'booking' => $booking
        ]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfPath = WRITEPATH . 'invoice-' . $id . '.pdf';

        file_put_contents(
            $pdfPath,
            $dompdf->output()
        );

        // Kirim email
        $email = service('email');

        $email->setTo($booking['email']);
        $email->setSubject('Laundry Anda Telah Selesai');
        $email->setMailType('html');

        $email->setMessage(
            view('email/completed', [
                'booking' => $booking
            ])
        );

        $email->attach($pdfPath);

        try {
            $email->send();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
        }

        // BARU redirect di paling bawah
        session()->setFlashdata(
            'pesan',
            'Pesanan berhasil diselesaikan! Email dan invoice berhasil dikirim.'
        );

        return redirect()->to('/staff/booking');
    }

    public function history()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('
            bookings.*,
            services.nama      AS nama_paket,
            users.nama_lengkap AS nama_pelanggan
        ');
        $builder->join('services', 'services.id = bookings.service_id');
        $builder->join('users',    'users.id    = bookings.user_id');
        $builder->where('bookings.staff_id', session()->get('id'));
        $builder->where('bookings.status',   'completed'); 
        $builder->orderBy('bookings.completed_at', 'DESC');

        $data = [
            'title'    => 'Riwayat Tugas Saya',
            'bookings' => $builder->get()->getResultArray()
        ];

        return view('staff/booking/history', $data);
    }

}