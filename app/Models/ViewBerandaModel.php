<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewBerandaModel extends Model
{
    protected $table = 'view_beranda_dosenbaupperpuskajur'; // Menggunakan nama VIEW
    protected $primaryKey = 'npm'; // Primary key dari VIEW (berdasarkan npm)

    public function getBerandaData($npm = null)
    {
        if ($npm) {
            return $this->where('npm', $npm)->first(); // Mengembalikan satu baris jika NPM spesifik diberikan
        }

        return $this->findAll(); // Mengembalikan semua data jika NPM tidak diberikan
    }
}