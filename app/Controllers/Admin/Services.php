<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class Services extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        // Memanggil model agar bisa digunakan di seluruh fungsi
        $this->serviceModel = new ServiceModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Kelola Layanan Laundry',
            'services' => $this->serviceModel->findAll() // Ambil semua data layanan
        ];
        
        return view('admin/services/index', $data);
    }

    // --- TEMPELKAN DI SINI (MULAI) ---

    public function create()
    {
        $data = [
            'title'      => 'Tambah Layanan Baru',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/services/create', $data);
    }

    public function store()
    {
        // 1. Validasi Input Form
        $rules = [
            'nama'   => 'required',
            'harga'  => 'required|numeric',
            'durasi' => 'required|numeric',
            'foto'   => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Mengurus Upload Foto
        $fotoFile = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fotoFile && $fotoFile->getError() != 4) {
            $namaFoto = $fotoFile->getRandomName();
            $fotoFile->move('uploads', $namaFoto); 
        }

        // 3. Simpan ke Database
        $this->serviceModel->save([
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga'     => $this->request->getPost('harga'),
            'durasi'    => $this->request->getPost('durasi'),
            'foto'      => $namaFoto
        ]);

        session()->setFlashdata('pesan', 'Layanan baru berhasil ditambahkan!');

        return redirect()->to('/admin/services');
    }

    // --- TEMPELKAN DI SINI (SELESAI) ---

    public function delete($id)
{
    // Cari data layanan berdasarkan ID
    $service = $this->serviceModel->find($id);

    // Jika ada file fotonya, hapus file tersebut dari folder public/uploads
    if ($service['foto']) {
        unlink('uploads/' . $service['foto']);
    }

    // Hapus data dari database
    $this->serviceModel->delete($id);

    session()->setFlashdata('pesan', 'Layanan berhasil dihapus!');
    return redirect()->to('/admin/services');
}

public function edit($id)
{
    $data = [
        'title'    => 'Edit Layanan',
        'service'  => $this->serviceModel->find($id),
        'validation' => \Config\Services::validation()
    ];
    return view('admin/services/edit', $data);
}

public function update($id)
    {
        $fotoFile = $this->request->getFile('foto');
        $serviceLama = $this->serviceModel->find($id);

        // Secara bawaan, gunakan nama foto lama
        $namaFoto = $this->request->getPost('fotoLama');

        // Cek apakah ada file foto baru yang diunggah dan tidak error
        if ($fotoFile && $fotoFile->isValid() && ! $fotoFile->hasMoved()) {
            
            // Buat nama baru dan pindahkan file ke folder uploads
            $namaFoto = $fotoFile->getRandomName();
            $fotoFile->move('uploads', $namaFoto);
            
            // Hapus foto lama HANYA JIKA datanya ada DAN filenya benar-benar ada di folder
            if (!empty($serviceLama['foto']) && file_exists('uploads/' . $serviceLama['foto'])) {
                unlink('uploads/' . $serviceLama['foto']);
            }
        }

        // Simpan pembaruan ke database
        $this->serviceModel->save([
            'id'        => $id,
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga'     => $this->request->getPost('harga'),
            'durasi'    => $this->request->getPost('durasi'),
            'foto'      => $namaFoto
        ]);

        session()->setFlashdata('pesan', 'Data layanan berhasil diubah!');
        return redirect()->to('/admin/services');
    }
}