<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ViewRiwayatAdmin;

class RiwayatAdmView extends BaseController
{
    use ResponseTrait;

    public function getRiwayatAdmin()
    {
        // Inisialisasi model
        $riwayatAdminModel = new ViewRiwayatAdmin();

        // Ambil data dari request POST (opsional npm dari Postman)
        $npm = $this->request->getPost('npm');

        // Ambil data dari model
        $data = $riwayatAdminModel->getRiwayatAdminData($npm);

        // Cek apakah data ditemukan
        if ($data) {
            return $this->respond([
                'status' => 'success',
                'message' => $npm ? 'Data riwayat admin ditemukan' : 'Semua data riwayat admin ditemukan',
                'data' => $data
            ], 200);
        } else {
            return $this->fail('Data tidak ditemukan', 404);
        }
    }
}