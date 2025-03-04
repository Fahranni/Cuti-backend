<?php
namespace App\Models;
use CodeIgniter\Model;

class CutiModel extends Model{
    protected $table = "cuti";
    protected $primaryKey = "id_cuti";
    
    protected $allowedFields = [
        
        "npm",
        "status",
        "tgl_pengajuan",
        "semester",
        "semester_cuti",
        "tahun_akademik",
        "alasan",
    ];
}