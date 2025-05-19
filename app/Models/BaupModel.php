<?php
namespace App\Models;
use CodeIgniter\Model;

class BaupModel extends Model
{
    protected $table = "baup";
    protected $primaryKey = "id_baup";
    protected $useAutoIncrement = false;

    protected $allowedFields = ["id_user", "nama_baup"];
}
