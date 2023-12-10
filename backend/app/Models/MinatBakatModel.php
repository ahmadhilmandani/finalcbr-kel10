<?php

namespace App\Models;

use CodeIgniter\Model;

class MinatBakatModel extends Model
{
    protected $table            = 'minat_bakat';
    protected $primaryKey       = 'id_minatbakat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected $builder;

    // Deklarasi builder agar tidak perlu mengulang setiap membuat function, DRY
    function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('minat_bakat');
    }

    // Tentu saja...
    function GetMinatBakat()
    {
        return $this->builder   ->select('minat_bakat.*')
                                ->get()
                                ->getResultArray();
    }

    // Memeriksa ID di Tabel Database
    function CekId($id)
    {
        $result = $this->builder    ->where('minat_bakat.id_minatbakat', $id)
                                    ->get()
                                    ->getResult();

        if ($result > 0) {
            return true;
        } else return false;
    }
}
