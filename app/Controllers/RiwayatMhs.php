<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\RiwayatMhsModel;

header('Access-Control-Allow-Origin: *'); // Atau ganti * dengan URL Laravel Anda
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');

class RiwayatMhs extends BaseController
{
    use ResponseTrait;

    public function getCuti()
    {
        // Inisialisasi model
        $cutiModel = new RiwayatMhsModel();

        // Ambil data dari request POST (misalnya npm dari Postman)
        $npm = $this->request->getPost('npm');

        // Validasi input
        if (empty($npm)) {
            return $this->fail('NPM harus diisi', 400);
        }

        // Ambil data dari model
        $data = $cutiModel->getCutiData($npm);

        // Cek apakah data ditemukan
        if ($data) {
            return $this->respond([
                'status' => 'success',
                'message' => 'Data cuti ditemukan',
                'data' => $data
            ], 200);
        } else {
            return $this->fail('Data cuti tidak ditemukan untuk NPM tersebut', 404);
        }
    }
}