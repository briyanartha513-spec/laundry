<?php

namespace App\Controllers;

use App\Models\ServiceModel;

class Home extends BaseController
{
    public function index(): string
    {
        $serviceModel = new ServiceModel();

        $data = [
            'title' => 'Home Laundry',
            'services' => $serviceModel->findAll()
        ];

        return view('home/index', $data);
    }

    public function testEmail()
    {
        $email = service('email');

        $email->setTo('salvadino.hanysah@gmail.com');
        $email->setSubject('Tes Email Laundry');

        $email->setMessage('Terima kasih telah menggunakan jasa laundry kami.');

        if ($email->send()) {
            echo 'Email berhasil dikirim';
        } else {
            echo $email->printDebugger(['headers']);
        }
    }
}
