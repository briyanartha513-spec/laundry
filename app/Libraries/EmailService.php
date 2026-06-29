<?php

namespace App\Libraries;

class EmailService
{
    public function sendCompletedMail($booking, $pdfPath)
    {
        $email = service('email');

        $email->setTo($booking['email']);

        $email->setSubject('Laundry Anda Sudah Selesai');

        $email->setMessage(view(
            'email/completed',
            ['booking' => $booking]
        ));

        $email->attach($pdfPath);

        return $email->send();
    }
}