<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewRiwayatMhs extends Model
{
    protected $table = 'view_mahasiswa_cuti'; // Menggunakan nama VIEW
    protected $primaryKey = 'npm'; // Primary key dari VIEW (berdasarkan npm)

    public function getMahasiswaCutiData($npm = null)
    {
        if ($npm) {
            return $this->where('npm', $npm)->first(); // Mengembalikan satu baris jika NPM spesifik diberikan
        }

        return $this->findAll(); // Mengembalikan semua data jika NPM tidak diberikan
    }
}