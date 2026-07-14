<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKeyFilter implements FilterInterface
{
    // Kunci rahasia API kamu
    private $secretApiKey = 'LAUNDRY_KEY_SECURE_2026';

    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Ambil X-API-KEY dari header request Postman
        $clientKey = $request->getHeaderLine('X-API-KEY');

        // 2. Jika API Key kosong atau salah, LANGSUNG BLOKIR di sini
        if ($clientKey !== $this->secretApiKey) {
            // Kita langsung inject response JSON error tanpa nunggu masuk Controller
            $response = service('response');
            return $response->setJSON([
                'status'  => 401,
                'error'   => true,
                'message' => 'Unauthorized! API Key Filter menolak akses Anda.'
            ])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biasanya dikosongkan
    }
}