<?php
namespace App\Models;
use CodeIgniter\Model;

class KorperpusModel extends Model{
    protected $table = "koor_perpus";
    protected $primaryKey = "id_koor";
    
    protected $allowedFields = [
        
        "id_user",
        "nama_koor_perpus",
        
    ];
}