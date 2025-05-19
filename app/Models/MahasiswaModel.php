<?php
namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = "mahasiswa";
    protected $primaryKey = "npm";
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        "npm",
        "id_user",
        "id_kajur",
        "nama_mahasiswa",
        "tempat_tanggal_lahir",
        "jenis_kelamin",
        "alamat",
        "agama",
        "angkatan",
        "program_studi",
        "no_hp",
        "email",
    ];
}
