<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pembayaran extends BaseController
{
    // Fungsi ini yang bakal dipanggil sama Routes.php kemarin
    public function success($id = null)
    {
        $data = [
            'title'    => 'Pembayaran Berhasil',
            'order_id' => $id
        ];

        // Ini bakal ngelempar tampilan ke file views/pembayaran/success_view.php
        return view('pembayaran/success_view', $data);
    }
}