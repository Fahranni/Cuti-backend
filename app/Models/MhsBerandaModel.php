<?php

namespace App\Models;

use CodeIgniter\Model;

class MhsBerandaModel extends Model
{
    protected $table = 'mahasiswa'; // Tabel utama
    protected $primaryKey = 'npm';  // Primary key dari tabel mahasiswa

    public function getMahasiswaData($npm)
    {
        return $this->select('mahasiswa.npm, mahasiswa.nama_mahasiswa, mahasiswa.tempat_tanggal_lahir, mahasiswa.jenis_kelamin, mahasiswa.agama, mahasiswa.angkatan, mahasiswa.program_studi, kajur.nama_jurusan, mahasiswa.alamat, mahasiswa.email, mahasiswa.no_hp')
                    ->join('kajur', 'mahasiswa.id_kajur = kajur.id_kajur')
                    ->where('mahasiswa.npm', $npm)
                    ->first();
    }
}