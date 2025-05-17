<?php

namespace App\Controllers;

use App\Models\CutiModel;
use App\Models\MahasiswaModel;
use CodeIgniter\API\ResponseTrait;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header(
    "Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization"
);

class Cuti extends BaseController
{
    use ResponseTrait;
    protected $cutiModel;
    protected $mahasiswaModel;

    public function __construct()
    {
        $this->cutiModel = new CutiModel();
        $this->mahasiswaModel = new MahasiswaModel();
    }

    public function index()
    {
        $data = $this->cutiModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->cutiModel->where("id_cuti", $id)->findAll();
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }

    public function getCutiByNpm($npm = null)
    {
        try {
            // Cek apakah parameter npm kosong
            if (empty($npm)) {
                return $this->fail("NPM mahasiswa harus diisi", 400);
            }

            // Query untuk mencari data berdasarkan nama
            $data = $this->cutiModel->where("npm", $npm)->findAll();

            // Cek apakah data ditemukan
            if (!empty($data)) {
                return $this->respond(
                    [
                        "status" => 200,
                        "message" => "Data cuti ditemukan",
                        "data" => $data,
                    ],
                    200
                );
            } else {
                return $this->failNotFound(
                    "Data cuti dengan NPM " . $npm . " tidak ditemukan"
                );
            }
        } catch (\Exception $e) {
            return $this->fail("Terjadi kesalahan: " . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        $data = $this->request->getPost();

        // Validasi: cek apakah npm ada di tabel mahasiswa
        $mahasiswaCheck = $this->mahasiswaModel
            ->where("npm", $data["npm"])
            ->first();
        if (!$mahasiswaCheck) {
            return $this->fail(
                [
                    "message" => "NPM tidak ditemukan di tabel mahasiswa",
                ],
                400
            );
        }

        $cutiCheck = $this->cutiModel->where("npm", $data["npm"])->first();
        if ($cutiCheck) {
            return $this->fail(
                [
                    "message" =>
                        "NPM sudah terdaftar untuk cuti, mahasiswa hanya boleh mengajukan cuti sekali",
                ],
                400
            );
        }

        // Simpan data ke tabel cuti
        if (!$this->cutiModel->save($data)) {
            return $this->fail($this->cutiModel->errors());
        }

        $response = [
            "status" => 200,
            "error" => null,
            "message" => [
                "success" => "Berhasil Menambah Data",
            ],
        ];
        return $this->respond($response, 200);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data["id_cuti"] = $id;

        // Check if record exists in cuti table
        $ifExist = $this->cutiModel->where("id_cuti", $id)->first();
        if (!$ifExist) {
            return $this->failNotFound("Data tidak ditemukan");
        }

        // Validasi: cek apakah npm ada di tabel mahasiswa
        $mahasiswaCheck = $this->mahasiswaModel
            ->where("npm", $data["npm"])
            ->first();
        if (!$mahasiswaCheck) {
            return $this->fail(
                [
                    "message" => "NPM tidak ditemukan di tabel mahasiswa",
                ],
                400
            );
        }

        // Validasi: cek apakah npm belum ada di tabel cuti (kecuali data saat ini)
        $cutiCheck = $this->cutiModel
            ->where("npm", $data["npm"])
            ->where("id_cuti !=", $id) // Kecualikan data saat ini
            ->first();
        if ($cutiCheck) {
            return $this->fail(
                [
                    "message" => "NPM sudah digunakan untuk cuti lain",
                ],
                400
            );
        }

        // Simpan perubahan ke tabel cuti
        if (!$this->cutiModel->save($data)) {
            return $this->fail($this->cutiModel->errors());
        }

        $response = [
            "status" => 200,
            "error" => null,
            "message" => [
                "success" => "Berhasil Mengubah Data",
            ],
        ];
        return $this->respond($response, 200);
    }

    public function delete($id = null)
    {
        $data = $this->cutiModel->where("id_cuti", $id)->findAll();
        if ($data) {
            $this->cutiModel->delete($id);
            $response = [
                "status" => 200,
                "error" => null,
                "message" => [
                    "success" => "Berhasil Menghapus Data",
                ],
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }
}
