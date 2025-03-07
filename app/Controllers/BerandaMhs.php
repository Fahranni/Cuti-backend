<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ViewBerandaMhs;

class BerandaMhs extends BaseController
{
    use ResponseTrait;

    public function getBerandaMahasiswa()
    {
        // Inisialisasi model
        $berandaMahasiswaModel = new ViewBerandaMhs();

        // Ambil data dari request POST (opsional npm dari Postman)
        $npm = $this->request->getPost('npm');

        // Ambil data dari model
        $data = $berandaMahasiswaModel->getBerandaMahasiswaData($npm);

        // Cek apakah data ditemukan
        if ($data) {
            return $this->respond([
                'status' => 'success',
                'message' => $npm ? 'Data beranda mahasiswa ditemukan' : 'Semua data beranda mahasiswa ditemukan',
                'data' => $data
            ], 200);
        } else {
            return $this->fail('Data tidak ditemukan', 404);
        }
    }
}