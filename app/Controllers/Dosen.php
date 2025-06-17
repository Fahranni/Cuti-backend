<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dosen extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new DosenModel();
    }
    
    public function index()
    {
       return $this->response->setJSON($this->model->findAll()); 
    }

    public function show($id = null)//Tampil data Dosen
    {
        $data = $this->model->find($id);
        if (!$data){
            return $this->response->setStatusCode(404)->setJSON(['message' => "Dosen Wali dengan ID $id tidak ditemukan."]);

        }
        return $this->response->setJSON($data);
    }

    public function create()//Tambah data dosen
    {
        $data = $this->request->getJSON(true);

        if(!isset($data['nama_dosen'], $data['nidn'], $data['id_user'])){
            return $this->response->setStatusCode(400)->setJSON(['message' => 'nama_dosen, nidn, dan id_user wajib diisi.']);
        }
        $this->model->insert($data);
        $data['id_dosen'] = $this->model->getInsertID();

        return $this->response->setStatusCode(201)->setJSON($data);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        $data['id_dosen'] = $id;

        if (!isset($data['nama_dosen'], $data['nidn'], $data['id_user'])) {
            return $this->response->setStatusCode(400)
                ->setJSON(['message' => 'nama_dosen, nidn, dan id_user wajib diisi.']);
        }

        if (!$this->model->find($id)) {
            return $this->response->setStatusCode(404)
                ->setJSON(['message' => "Dosen Wali dengan ID $id tidak ditemukan."]);
        }

        $this->model->update($id, $data);
        return $this->response->setJSON($data);
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->response->setStatusCode(404)
                ->setJSON(['message' => "Dosen Wali dengan ID $id tidak ditemukan."]);
        }

        $this->model->delete($id);
        return $this->response->setJSON(['message' => "Dosen Wali dengan ID $id berhasil dihapus."]);
    }
}
