<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class Booking extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
    }

    public function index()
    {
        return view('customer/booking/index', [
            'title'    => 'Pesan Layanan Laundry',
            'services' => $this->serviceModel->findAll()
        ]);
    }

    public function save()
    {
        $bookingModel = new \App\Models\BookingModel();

        $serviceId = $this->request->getPost('service_id');
        $berat     = $this->request->getPost('berat');

        $service = $this->serviceModel->find($serviceId);

        $bookingModel->save([
            'user_id'         => session()->get('id'),
            'service_id'      => $serviceId,
            'berat'           => $berat,
            'tanggal_booking' => date('Y-m-d'),
            'total_harga'     => $service['harga'] * $berat,
            'status'          => 'pending'
        ]);

        return redirect()->to('/customer/booking')
            ->with('pesan', 'Hore! Pesanan berhasil dibuat. Silakan tunggu konfirmasi Admin.');
    }

    public function edit($id)
    {
        $bookingModel = new \App\Models\BookingModel();

        $booking = $bookingModel->find($id);

        if ($booking['status'] !== 'pending') {
            return redirect()->to('/customer/history')
                ->with('error', 'Pesanan sudah diproses, tidak dapat diedit.');
        }

        return view('customer/edit_booking', [
            'title'    => 'Edit Pesanan Laundry',
            'booking'  => $booking,
            'services' => $this->serviceModel->findAll()
        ]);
    }

    public function update($id)
    {
        $bookingModel = new \App\Models\BookingModel();

        $bookingLama = $bookingModel->find($id);

        $layananLama = $this->serviceModel->find($bookingLama['service_id']);
        $berat       = $bookingLama['total_harga'] / $layananLama['harga'];

        $serviceBaru = $this->serviceModel->find(
            $this->request->getPost('service_id')
        );

        $bookingModel->save([
            'id'          => $id,
            'service_id'  => $serviceBaru['id'],
            'total_harga' => $serviceBaru['harga'] * $berat
        ]);

        return redirect()->to('/customer/history')
            ->with('pesan', 'Pesanan berhasil diubah!');
    }

    public function delete($id)
    {
        $bookingModel = new \App\Models\BookingModel();

        $booking = $bookingModel->find($id);

        if ($booking['status'] !== 'pending') {
            return redirect()->to('/customer/history')
                ->with('error', 'Pesanan sudah diproses, tidak bisa dihapus!');
        }

        $bookingModel->delete($id);

        return redirect()->to('/customer/history')
            ->with('pesan', 'Pesanan berhasil dihapus!');
    }

public function invoice($id)
    {
        // 1. Ambil data dari database
        $db = \Config\Database::connect();
        $booking = $db->table('bookings')->where('id', $id)->get()->getRowArray();
        
        if (!$booking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $user = $db->table('users')->where('id', $booking['user_id'])->get()->getRowArray();
        $service = $db->table('services')->where('id', $booking['service_id'])->get()->getRowArray();

        $booking['nama_pelanggan'] = $user['nama_lengkap'];
        $booking['nama_paket'] = $service['nama'];
        $email_pelanggan = $user['email'];

        // 2. Generate PDF (pake library lu)
        $pdfLib = new \App\Libraries\PdfGenerator();
        // PASTIIN ADA $booking di dalam kurung ini:
        $filePath = $pdfLib->generateInvoice($booking); 

        // 3. Kirim Email
        $email = \Config\Services::email();
        $email->setTo($email_pelanggan);
        $email->setSubject('Invoice Laundry #' . $id);
        $email->setMessage('Halo ' . $user['nama_lengkap'] . ', invoice pesanan Anda sudah terlampir.');
        $email->attach($filePath);

        if ($email->send()) {
            // 4. Download file
            return $this->response->download($filePath, null);
        } else {
            return "Gagal kirim email: " . $email->printDebugger(['headers']);
        }
    }
}