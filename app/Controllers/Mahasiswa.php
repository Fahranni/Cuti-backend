<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DosenModel;
use App\Models\KajurModel;
use App\Models\MahasiswaModel;
use CodeIgniter\API\ResponseTrait;

header('Access-Control-Allow-Origin: *'); // Atau ganti * dengan URL Laravel Anda
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');

class Mahasiswa extends BaseController
{
    use ResponseTrait;
    protected $userModel;
    protected $mahasiswaModel;
    protected $dosenModel;
    protected $kajurModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->dosenModel = new DosenModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->kajurModel = new KajurModel();
    }

    public function index()
    {
        $data = $this->mahasiswaModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->mahasiswaModel->where("npm", $id)->findAll();
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }

    public function create()
    {
        $data = $this->request->getPost();

        $npmCheck = $this->mahasiswaModel->where('npm', $data['npm'])->first();
        if ($npmCheck) {
            return $this->fail([
                'message' => 'NPM sudah digunakan'
            ], 400);
        }

        // Validasi id_user di tabel user
        $userCheck = $this->userModel->where('id_user', $data['id_user'])->where('username', $data['nama_mahasiswa'])->first();
        if (!$userCheck) {
            return $this->fail([
                'message' => 'ID User tidak sesuai dengan yang ada di tabel user'
            ], 400);
        }

        // Validasi id_dosen di tabel dosen
        $dosenCheck = $this->dosenModel->where('id_dosen', $data['id_dosen'])->first();
        if (!$dosenCheck) {
            return $this->fail([
                'message' => 'ID Dosen tidak ditemukan di tabel dosen'
            ], 400);
        }

        // Validasi id_kajur di tabel kajur
        $kajurCheck = $this->kajurModel->where('id_kajur', $data['id_kajur'])->first();
        if (!$kajurCheck) {
            return $this->fail([
                'message' => 'ID Kajur tidak ditemukan di tabel kajur'
            ], 400);
        }

        // Simpan data ke tabel mahasiswa jika semua validasi lolos
        if (!$this->mahasiswaModel->save($data)) {
            return $this->fail($this->mahasiswaModel->errors());
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
        $data['npm'] = $id;

        // Check if record exists in mahasiswa table
        $ifExist = $this->mahasiswaModel->where('npm', $id)->findAll();
        if (!$ifExist) {
            return $this->failNotFound("Data tidak ditemukan");
        }

            $npmCheck = $this->mahasiswaModel->where('npm', $data['npm'])
                ->where('npm !=', $id) 
                ->first();
            if ($npmCheck) {
                return $this->fail([
                    'message' => 'NPM sudah digunakan'
                ], 400);
            }
        


        $userCheck = $this->userModel->where('id_user', $data['id_user'])
            ->where('username', $data['nama_mahasiswa'])
            ->first();

        if (!$userCheck) {
            return $this->fail([
                'message' => 'ID User dan username tidak sesuai dengan data di tabel user'
            ], 400);
        }


        // Validasi id_dosen di tabel dosen jika dikirim

        $dosenCheck = $this->dosenModel->where('id_dosen', $data['id_dosen'])->first();
        if (!$dosenCheck) {
            return $this->fail([
                'message' => 'ID Dosen tidak ditemukan di tabel dosen'
            ], 400);
        }


        // Validasi id_kajur di tabel kajur jika dikirim

        $kajurCheck = $this->kajurModel->where('id_kajur', $data['id_kajur'])->first();
        if (!$kajurCheck) {
            return $this->fail([
                'message' => 'ID Kajur tidak ditemukan di tabel kajur'
            ], 400);
        }


        // Simpan perubahan ke tabel mahasiswa
        if (!$this->mahasiswaModel->save($data)) {
            return $this->fail($this->mahasiswaModel->errors());
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
        $data = $this->mahasiswaModel->where('npm', $id)->findAll();
        if ($data) {
            $this->mahasiswaModel->delete($id);
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
