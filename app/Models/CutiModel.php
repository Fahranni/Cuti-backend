<?php

namespace App\Models;

use CodeIgniter\Model;

class CutiModel extends Model
{
    protected $table = "cuti";
    protected $primaryKey = "id_cuti"; // <--- WAJIB ADA!

    protected $allowedFields = [
        "id_cuti",
        "npm",
        "semester",
        "tgl_pengajuan",
        "dokumen_pendukung",
        "alasan",
        "status",
        "id_user",
        "nama_mahasiswa",

        // tambahkan semua kolom lain yang boleh diisi
    ];

    protected $useAutoIncrement = true; // <--- Pastikan ini true
    protected $returnType = "object"; // atau 'object' sesuai kebutuhan
}
