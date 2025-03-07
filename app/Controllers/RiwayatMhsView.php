<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ViewRiwayatMhs;

class RiwayatMhsView extends BaseController
{
    use ResponseTrait;

    public function getMahasiswaCuti()
    {
        // Inisialisasi model
        $mahasiswaCutiModel = new ViewRiwayatMhs();

        // Ambil data dari request POST (opsional npm dari Postman)
        $npm = $this->request->getPost('npm');

        // Ambil data dari model
        $data = $mahasiswaCutiModel->getMahasiswaCutiData($npm);

        // Cek apakah data ditemukan
        if ($data) {
            return $this->respond([
                'status' => 'success',
                'message' => $npm ? 'Data mahasiswa cuti ditemukan' : 'Semua data mahasiswa cuti ditemukan',
                'data' => $data
            ], 200);
        } else {
            return $this->fail('Data tidak ditemukan', 404);
        }
    }
}