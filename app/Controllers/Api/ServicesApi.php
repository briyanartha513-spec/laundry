public function index()
{
    $model = new \App\Models\ServiceModel();
    return $this->response->setJSON($model->findAll());
}