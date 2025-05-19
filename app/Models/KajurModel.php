<?php
namespace App\Models;
use CodeIgniter\Model;

class KajurModel extends Model
{
    protected $table = "kajur";
    protected $primaryKey = "id_kajur";
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        "id_user",
        "nama_kajur",
        "nidn",
        "nama_jurusan",
    ];
}
