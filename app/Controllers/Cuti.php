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
        return $this->respond($data);
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
            if (empty($npm)) {
                return $this->fail("NPM mahasiswa harus diisi", 400);
            }

            $data = $this->cutiModel->where("npm", $npm)->findAll();

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

    // --- TAMBAHKAN METHOD INI untuk opsi B (POST /cuti/{npm}) ---
    public function createWithNpm($npm = null)
    {
        // Cek apakah parameter npm ada
        if (!$npm) {
            return $this->fail("NPM tidak boleh kosong", 400);
        }

        // Ambil data POST JSON dari request body
        $data = $this->request->getJSON(true); // ambil sebagai array

        // Set npm dari URL ke data supaya sinkron
        $data["npm"] = $npm;

        // Validasi: cek apakah npm ada di tabel mahasiswa
        $mahasiswaCheck = $this->mahasiswaModel->where("npm", $npm)->first();
        if (!$mahasiswaCheck) {
            return $this->fail(
                [
                    "message" => "NPM tidak ditemukan di tabel mahasiswa",
                ],
                400
            );
        }

        // Cek apakah mahasiswa sudah ada pengajuan cuti
        $cutiCheck = $this->cutiModel->where("npm", $npm)->first();
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
        if (!$this->cutiModel->update($data)) {
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

    // METHOD create() yang lama tetap ada untuk POST /cuti (tanpa npm di URL)
    public function create()
    {
        //tambahin ini
        $data = $this->request->getJSON(true);
        if (!isset($data['npm']) || !$data['npm']) {
        return $this->fail(['message' => 'Field NPM wajib diisi'], 400);
        }
        
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

        // Cek apakah mahasiswa sudah ada pengajuan cuti
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
    $data = $this->request->getJSON(true);


    // Pastikan data ada
    if (!$data) {
        return $this->fail('Data kosong atau tidak valid', 400);
    }

    // Validasi ID
    $ifExist = $this->cutiModel->where("id_cuti", $id)->first();
    if (!$ifExist) {
        return $this->failNotFound("Data tidak ditemukan");
    }

    // Validasi mahasiswa
    $mahasiswaCheck = $this->mahasiswaModel
        ->where("npm", $data["npm"])
        ->first();
    if (!$mahasiswaCheck) {
        return $this->fail(
            ["message" => "NPM tidak ditemukan di tabel mahasiswa"],
            400
        );
    }

    // Jangan kirim primary key ke update
    unset($data['id_cuti']);

    // Lakukan update eksplisit
    if (!$this->cutiModel->update($id, $data)) {
        return $this->fail($this->cutiModel->errors());
    }

    // Pastikan data benar-benar berubah
    if ($this->cutiModel->db->affectedRows() === 0) {
        return $this->fail("Data tidak berubah", 400);
    }

    return $this->respond([
        "status" => 200,
        "error" => null,
        "message" => "Data berhasil diperbarui"
    ]);
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
