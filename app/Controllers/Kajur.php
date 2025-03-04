<?php

namespace App\Controllers;

use App\Models\KajurModel;
use App\Models\UserModel; // Tambahkan model untuk tabel user
use App\Models\DosenModel; // Tambahkan model untuk tabel admin
use CodeIgniter\API\ResponseTrait;

header('Access-Control-Allow-Origin: *'); // Atau ganti * dengan URL Laravel Anda
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');

class Kajur extends BaseController
{
    use ResponseTrait;
    protected $kajurModel; // Ganti jadi protected agar lebih terorganisir
    protected $userModel;  // Tambahkan untuk akses UserModel
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
        $data = $this->kajurModel->where("id_dosen", $id)->findAll();
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }

    public function create()
    {
        $data = $this->request->getPost();

        // Validasi: cek apakah id_user dan username sesuai di tabel user
        $userCheck = $this->userModel->where('id_user', $data['id_user'])
            ->where('username', $data['nama_kajur'])
            ->first();
        $nidnCheck = $this->dosenModel->where('nidn', $data['nidn'])
            ->where('nama_dosen', $data['nama_kajur'])
            ->first();

        if (!$userCheck || !$nidnCheck) {
            return $this->fail([
                'message' => 'ID User, username, atau NIDN tidak sesuai dengan data di tabel user atau dosen'
            ], 400);
        }

        // Simpan data ke tabel admin
        if (!$this->kajurModel->save($data)) {
            return $this->fail($this->kajurModel->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => 'Berhasil Menambah Data',
            ]
        ];
        return $this->respond($response, 200);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_kajur'] = $id;

        // Check if record exists in admin table
        $ifExist = $this->kajurModel->where('id_kajur', $id)->findAll();
        if (!$ifExist) {
            return $this->failNotFound("Data tidak ditemukan");
        }

        // Validasi: cek apakah id_user dan username sesuai di tabel user
        $userCheck = $this->userModel->where('id_user', $data['id_user'])
            ->where('username', $data['nama_kajur'])
            ->first();

        $nidnCheck = $this->dosenModel->where('nidn', $data['nidn'])
            ->where('nama_dosen', $data['nama_kajur'])
            ->first();

        if (!$userCheck || !$nidnCheck) {
            return $this->fail([
                'message' => 'ID User, username, atau NIDN tidak sesuai dengan data di tabel user atau dosen'
            ], 400);
        }

        // Simpan perubahan ke tabel admin
        if (!$this->kajurModel->save($data)) {
            return $this->fail($this->kajurModel->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => 'Berhasil Mengubah Data',
            ]
        ];
        return $this->respond($response, 200);
    }

    public function delete($id = null)
    {
        $data = $this->kajurModel->where('id_kajur', $id)->findAll();
        if ($data) {
            $this->kajurModel->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => [
                    'success' => 'Berhasil Menghapus Data',
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }
}
