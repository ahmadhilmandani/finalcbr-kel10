<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseCaseModel extends Model
{
    protected $table            = 'base_case';
    protected $primaryKey       = 'id_basecase';
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

    function __construct(){
        parent::__construct();
        $this->builder = $this->db->table('base_case');
    }

    function GetCaseBase(){ 
        return $this->builder   ->select('base_case.*, kasus.*, siswa.*, minat_bakat.*')
                                ->join('kasus', 'kasus.id_kasus = base_case.id_kasus')
                                ->join('minat_bakat', 'minat_bakat.id_minatbakat = kasus.id_minatbakat')
                                ->join('siswa', 'kasus.id_siswa = siswa.id_siswa')
                                ->get()
                                ->getResultArray();
    }

    function GetCaseBasePernyataan(){
        $result = $this->builder    ->select('base_case.*, siswa.*, kasus.*, minat_bakat.*, GROUP_CONCAT(pernyataan_siswa.id_pernyataan) AS id_pernyataan')
                                    ->join('kasus', 'kasus.id_kasus = base_case.id_kasus')
                                    ->join('siswa', 'kasus.id_siswa = siswa.id_siswa')
                                    ->join('pernyataan_siswa', 'pernyataan_siswa.id_kasus = kasus.id_kasus')
                                    ->join('pernyataan', 'pernyataan.id_pernyataan = pernyataan_siswa.id_pernyataan')
                                    ->join('minat_bakat', 'minat_bakat.id_minatbakat = kasus.id_minatbakat')
                                    ->groupBy('kasus.id_kasus')
                                    ->get()
                                    ->getResultArray();
        
        // Memisahkan hasil dari GROUP_CONCAT menjadi array
        foreach ( $result as $result ){
            $result['id_pernyataan'] = explode(',', $result['id_pernyataan']);
            $cases[] = $result;
        }

        return $cases;
    }

    function CekId($id){
        $result = $this->builder    ->where('kasus.id_basecase', $id)
                                    ->get()
                                    ->getResult();

        if($result > 0){
            return true;
        } else return false;
    }
}
