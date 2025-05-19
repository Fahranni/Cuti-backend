<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ViewBerandaModel;

class BerandaDosen extends BaseController
{
    use ResponseTrait;

    public function getBerandaData()
    {
        // Inisialisasi model
        $berandaDosenModel = new ViewBerandaModel();

        // Ambil data dari request POST (opsional npm dari Postman)
        $npm = $this->request->getPost('npm');

        // Ambil data dari model
        $data = $berandaDosenModel->getBerandaData($npm);

        // Cek apakah data ditemukan
        if ($data) {
            return $this->respond([
                'status' => 'success',
                'message' => $npm ? 'Data beranda ditemukan' : 'Semua data beranda ditemukan',
                'data' => $data
            ], 200);
        } else {
            return $this->fail('Data tidak ditemukan', 404);
        }
    }
}