<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanCutiModel extends Model
{
    protected $table = 'mahasiswa'; // Tabel utama
    protected $primaryKey = 'npm';  // Primary key dari tabel mahasiswa

    public function getMahasiswaCutiData($npm = null)
    {
        $builder = $this->select('user.username, mahasiswa.npm, mahasiswa.nama_mahasiswa, mahasiswa.program_studi, kajur.nama_jurusan, mahasiswa.email, dosen_wali.nama_dosen, kajur.nama_kajur, cuti.status, cuti.tgl_pengajuan')
                        ->join('user', 'mahasiswa.id_user = user.id_user')
                        ->join('dosen_wali', 'mahasiswa.id_dosen = dosen_wali.id_dosen')
                        ->join('kajur', 'mahasiswa.id_kajur = kajur.id_kajur')
                        ->join('cuti', 'mahasiswa.npm = cuti.npm', 'left');

        if ($npm) {
            $builder->where('mahasiswa.npm', $npm);
            return $builder->first(); // Mengembalikan satu baris jika NPM spesifik diberikan
        }

        return $builder->findAll(); // Mengembalikan semua data jika NPM tidak diberikan
    }
}