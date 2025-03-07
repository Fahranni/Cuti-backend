<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\RiwayatAdminModel;

header('Access-Control-Allow-Origin: *'); // Atau ganti * dengan URL Laravel Anda
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');

class RiwayatAdmin extends BaseController
{
    use ResponseTrait;

    public function getRiwayatAdmin()
    {
        // Inisialisasi model
        $riwayatAdminModel = new RiwayatAdminModel();

        // Ambil data dari request POST (opsional npm dari Postman)
        $npm = $this->request->getPost('npm');

        // Ambil data dari model
        $data = $riwayatAdminModel->getRiwayatAdmin($npm);

        // Cek apakah data ditemukan
        if ($data) {
            return $this->respond([
                'status' => 'success',
                'message' => $npm ? 'Data mahasiswa dan detail cuti ditemukan' : 'Semua data mahasiswa dan detail cuti ditemukan',
                'data' => $data
            ], 200);
        } else {
            return $this->fail('Data tidak ditemukan', 404);
        }
    }
}