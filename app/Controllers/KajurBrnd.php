<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ViewBerandaKajur;

class KajurBrnd extends BaseController
{
    use ResponseTrait;

    public function getBerandaKajurCntrl()
    {
        // Inisialisasi model
        $kajurBeranda = new ViewBerandaKajur();

        // Ambil data dari request POST (opsional npm dari Postman)
        $npm = $this->request->getPost("npm");

        // Ambil data dari model
        $data = $kajurBeranda->getBerandaKajurData($npm);

        // Cek apakah data ditemukan
        if ($data) {
            return $this->respond(
                [
                    "status" => "success",
                    "message" => $npm
                        ? "Data beranda kajur ditemukan"
                        : "Semua data beranda kajur ditemukan",
                    "data" => $data,
                ],
                200
            );
        } else {
            return $this->fail("Data tidak ditemukan", 404);
        }
    }
}
