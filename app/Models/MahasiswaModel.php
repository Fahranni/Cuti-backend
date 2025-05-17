<?php
namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = "mahasiswa";
    protected $primaryKey = "npm";
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        "id_user",
        "id_dosen",
        "id_kajur",
        "nama_mahasiswa",
        "tempat_tanggal_lahir",
        "jenis_kelamin",
        "alamat",
        "agama",
        "angkatan",
        "program_studi",
        "semester",

        "no_hp",
        "email",
    ];
}
