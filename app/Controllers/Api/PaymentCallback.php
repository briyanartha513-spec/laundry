public function index()
{
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    $bookingModel = new \App\Models\BookingModel();

    if ($data->transaction_status == 'settlement') {
        $bookingModel->update($data->order_id, [
            'status' => 'confirmed'
        ]);
    }
    $email = new \App\Libraries\EmailService();

$email->send(
    $userEmail,
    'Pembayaran Berhasil',
    'Pembayaran kamu berhasil'
);
}