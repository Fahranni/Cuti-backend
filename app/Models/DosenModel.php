<?php
namespace App\Models;
use CodeIgniter\Model;

class DosenModel extends Model{
    protected $table = "dosen_wali";
    protected $primaryKey = "id_dosen";
    
    protected $allowedFields = [
        
        "id_user",
        "nama_dosen",
        "nidn",
    ];
}