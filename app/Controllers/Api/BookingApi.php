public function status($id)
{
    $model = new \App\Models\BookingModel();
    return $this->response->setJSON($model->find($id));
}