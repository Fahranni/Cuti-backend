<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\UserModel; // Tambahkan model untuk tabel user
use CodeIgniter\API\ResponseTrait;

header('Access-Control-Allow-Origin: *'); // Atau ganti * dengan URL Laravel Anda
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');

class Dosen extends BaseController
{
    use ResponseTrait;
    protected $dosenModel; // Ganti jadi protected agar lebih terorganisir
    protected $userModel;  // Tambahkan untuk akses UserModel

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->userModel = new UserModel(); // Inisialisasi UserModel
    }

    public function index()
    {
        $data = $this->dosenModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->dosenModel->where("id_dosen", $id)->findAll();
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
            ->where('username', $data['nama_dosen'])
            ->first();
            

        if (!$userCheck) {
            return $this->fail([
                'message' => 'ID User dan username tidak sesuai dengan data di tabel user'
            ], 400);
        }

        $dosenCheck = $this->dosenModel->where('nama_dosen', $data['nama_dosen'])->first();
        if ($dosenCheck) {
            return $this->fail([
                'message' => 'Nama Dosen sudah ada di tabel dosen'
            ], 400);
        }

        // Simpan data ke tabel admin
        if (!$this->dosenModel->save($data)) {
            return $this->fail($this->dosenModel->errors());
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
        $data['id_dosen'] = $id;

        // Check if record exists in admin table
        $ifExist = $this->dosenModel->where('id_dosen', $id)->findAll();
        if (!$ifExist) {
            return $this->failNotFound("Data tidak ditemukan");
        }

        // Validasi: cek apakah id_user dan username sesuai di tabel user
        $userCheck = $this->userModel->where('id_user', $data['id_user'])
            ->where('username', $data['nama_dosen'])
            ->first();

        if (!$userCheck) {
            return $this->fail([
                'message' => 'ID User dan username tidak sesuai dengan data di tabel user'
            ], 400);
        }

        
            $dosenCheck = $this->dosenModel->where('nama_dosen', $data['nama_dosen'])
                                           ->where('id_dosen !=', $id)
                                           ->first();
            if ($dosenCheck) {
                return $this->fail([
                    'message' => 'Nama Dosen sudah ada di tabel dosen'
                ], 400);
            }
        

        // Simpan perubahan ke tabel admin
        if (!$this->dosenModel->save($data)) {
            return $this->fail($this->dosenModel->errors());
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
        $data = $this->dosenModel->where('id_dosen', $id)->findAll();
        if ($data) {
            $this->dosenModel->delete($id);
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
