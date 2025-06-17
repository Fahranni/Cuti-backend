<?php

namespace App\Controllers;

use App\Models\KajurModel;
use App\Models\UserModel; // Tambahkan model untuk tabel user
use App\Models\DosenModel; // Tambahkan model untuk tabel admin
use CodeIgniter\API\ResponseTrait;

header("Access-Control-Allow-Origin: *"); // Atau ganti * dengan URL Laravel Anda
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header(
    "Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization"
);

class Kajur extends BaseController
{
    use ResponseTrait;
    protected $kajurModel; // Ganti jadi protected agar lebih terorganisir
    protected $userModel; // Tambahkan untuk akses UserModel
    protected $dosenModel;

    public function __construct()
    {
        $this->kajurModel = new KajurModel();
        $this->userModel = new UserModel(); // Inisialisasi UserModel
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        $data = $this->kajurModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->kajurModel->where("id_kajur", $id)->findAll();
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        // Validasi: cek apakah id_user dan username sesuai di tabel user
        $userCheck = $this->userModel
            ->where("id_user", $data["id_user"])
            ->where("username", $data["nama_kajur"])
            ->first();

        if (!$userCheck) {
            return $this->fail(
                [
                    "message" =>
                        "ID User atau username tidak sesuai dengan data di tabel user",
                ],
                400
            );
        }

        $kajurCheck = $this->kajurModel
            ->where("nama_kajur", $data["nama_kajur"])
            ->first();
        if ($kajurCheck) {
            return $this->fail(
                [
                    "message" => "Nama Kajur sudah ada di tabel kajur",
                ],
                400
            );
        }

        $jurusanCheck = $this->kajurModel
            ->where("nama_jurusan", $data["nama_jurusan"])
            ->first();
        if ($jurusanCheck) {
            return $this->fail(
                [
                    "message" => "Nama Jurusan sudah ada di tabel kajur",
                ],
                400
            );
        }

        // Simpan data ke tabel admin
        if (!$this->kajurModel->save($data)) {
            return $this->fail($this->kajurModel->errors());
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
        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();//ubah

        $data["id_kajur"] = $id;

        if (!isset($data["id_user"]) || !isset($data["nama_kajur"])) {
        return $this->fail([
            "message" => "id_user dan nama_kajur wajib diisi saat update"
        ], 400);
    }

        // Check if record exists in admin table
        $ifExist = $this->kajurModel->where("id_kajur", $id)->findAll();
        if (!$ifExist) {
            return $this->failNotFound("Data tidak ditemukan");
        }

        // Validasi: cek apakah id_user dan username sesuai di tabel user
        $userCheck = $this->userModel
            ->where("id_user", $data["id_user"])
            ->where("username", $data["nama_kajur"])
            ->first();

        if (!$userCheck) {
            return $this->fail(
                [
                    "message" =>
                        "ID User atau username tidak sesuai dengan data di tabel user",
                ],
                400
            );
        }

        $kajurCheck = $this->kajurModel
            ->where("nama_kajur", $data["nama_kajur"])
            ->where("id_kajur !=", $id)
            ->first();
        if ($kajurCheck) {
            return $this->fail(
                [
                    "message" => "Nama Kajur sudah ada di tabel kajur",
                ],
                400
            );
        }

        $jurusanCheck = $this->kajurModel
            ->where("nama_jurusan", $data["nama_jurusan"])
            ->where("id_kajur !=", $id)
            ->first();
        if ($jurusanCheck) {
            return $this->fail(
                [
                    "message" => "Nama Jurusan sudah ada di tabel kajur",
                ],
                400
            );
        }

        // Simpan perubahan ke tabel admin
        if (!$this->kajurModel->save($data)) {
            return $this->fail($this->kajurModel->errors());
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
        $data = $this->kajurModel->where("id_kajur", $id)->findAll();
        if ($data) {
            $this->kajurModel->delete($id);
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

    public function options($id = null)
    {
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->setStatusCode(200);
    }
}
