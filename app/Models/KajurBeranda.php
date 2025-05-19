<?php

namespace App\Models;

use CodeIgniter\Model;

class KajurBeranda extends Model
{
    protected $table = "mahasiswa"; // Tabel utama
    protected $primaryKey = "npm"; // Primary key dari tabel mahasiswa

    public function getBerandaKajur($npm = null)
    {
        $builder = $this->select(
            "user.username, mahasiswa.npm, mahasiswa.nama_mahasiswa, mahasiswa.program_studi, kajur.nama_jurusan, mahasiswa.email, kajur.nama_kajur, cuti.semester, cuti.tgl_pengajuan"
        )
            ->join("user", "mahasiswa.id_user = user.id_user")
            ->join("kajur", "mahasiswa.id_kajur = kajur.id_kajur")
            ->join("cuti", "mahasiswa.npm = cuti.npm");

        if ($npm) {
            $builder->where("mahasiswa.npm", $npm);
            return $builder->first(); // Mengembalikan satu baris jika NPM spesifik diberikan
        }

        return $builder->findAll(); // Mengembalikan semua data jika NPM tidak diberikan
    }
}
