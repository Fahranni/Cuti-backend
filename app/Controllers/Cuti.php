<?php

namespace App\Controllers;

use App\Models\CutiModel;
use App\Models\MahasiswaModel; // Tambahkan model untuk tabel user
use CodeIgniter\API\ResponseTrait;

header('Access-Control-Allow-Origin: *'); // Atau ganti * dengan URL Laravel Anda
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');

class Cuti extends BaseController
{
    use ResponseTrait;
    protected $cutiModel; // Ganti jadi protected agar lebih terorganisir
    protected $mahasiswaModel;  // Tambahkan untuk akses UserModel

    public function __construct()
    {
        $this->cutiModel = new CutiModel();
        //$this->mahasiswaModel = new MahasiswaModel(); // Inisialisasi UserModel
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

    public function create()
    {
        $data = $this->request->getPost();

        // Validasi: cek apakah id_user dan username sesuai di tabel user
        //$userCheck = $this->mahasiswaModel->where('npm', $data['npm'])->first();

        /*if (!$userCheck) {
            return $this->fail([
                'message' => 'NPM tidak sesuai dengan data di tabel mahasiswa'
            ], 400);
        }*/

        // Simpan data ke tabel admin
        if (!$this->cutiModel->save($data)) {
            return $this->fail($this->cutiModel->errors());
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
        $data['id_cuti'] = $id;

        // Check if record exists in admin table
        $ifExist = $this->cutiModel->where('id_cuti', $id)->findAll();
        if (!$ifExist) {
            return $this->failNotFound("Data tidak ditemukan");
        }

        // Validasi: cek apakah id_user dan username sesuai di tabel user
        //$userCheck = $this->mahasiswaModel->where('npm', $data['npm'])->first();

        /*if (!$userCheck) {
            return $this->fail([
                'message' => 'NPM tidak sesuai dengan data di tabel mahasiswa'
            ], 400);
        }*/

        // Simpan perubahan ke tabel admin
        if (!$this->cutiModel->save($data)) {
            return $this->fail($this->cutiModel->errors());
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
        $data = $this->cutiModel->where('id_cuti', $id)->findAll();
        if ($data) {
            $this->cutiModel->delete($id);
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
