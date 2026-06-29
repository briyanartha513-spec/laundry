<?php

namespace App\Libraries;

use Dompdf\Dompdf;

class PdfGenerator
{
    // 1. Variabel ini wajib ada biar fungsi getDompdf() punya data
    protected $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    // 2. Ini fungsi generateInvoice lu yang asli
    public function generateInvoice($booking)
    {
        $html = view('pdf/invoice', [
            'booking' => $booking
        ]);

        // Pake $this->dompdf biar sinkron sama fungsi getDompdf()
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        $path = WRITEPATH . 'invoice-' . $booking['id'] . '.pdf';

        file_put_contents(
            $path,
            $this->dompdf->output()
        );

        return $path;
    }

    // 3. INI FUNGSI YANG LU TANYAIN, TARO DI SINI (di dalam class, di bawah fungsi generateInvoice)
    public function getDompdf()
    {
        return $this->dompdf;
    }
}