<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatMhsModel extends Model
{
    protected $table = 'mahasiswa'; // Tabel utama
    protected $primaryKey = 'npm';  // Primary key dari tabel mahasiswa

    public function getCutiData($npm)
    {
        return $this->select('mahasiswa.npm, mahasiswa.nama_mahasiswa, mahasiswa.program_studi, kajur.nama_jurusan, mahasiswa.angkatan, cuti.semester')
                    ->join('cuti', 'mahasiswa.npm = cuti.npm')
                    ->join('kajur', 'mahasiswa.id_kajur = kajur.id_kajur')
                    ->where('cuti.id_cuti IS NOT NULL')
                    ->where('mahasiswa.npm', $npm)
                    ->first();
    }
}