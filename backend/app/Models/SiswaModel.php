<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = ['*'];

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
        $this->builder = $this->db->table('siswa');
    }

    // Tentu saja...
    function GetSiswa()
    {
        return $this->builder   ->select('siswa.*')
                                ->get()
                                ->getResultArray();
    }

    // Insert ke Database
    function insertData($data){
        $number = 1;
        $siswapre_id = 'S';
        // Memeriksa ID kasus sampai ditemukan yang tersedia
        while ($this->CekId($siswapre_id.$number)){
            $number++;
            $id_siswa = $siswapre_id.$number;
        }
        // Set variabel data untuk input ke database
        $data_siswa = [
            'id_siswa' => $id_siswa,
            //'nama' => $nama,
            'umur' => $data['umur'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'kelas' => $data['kelas'],
        ];
        $this->insert($data_siswa);
    }

    // Memeriksa ID di Tabel Database
    function CekId($id)
    {
        $result = $this->builder    ->where('siswa.id_siswa', $id)
                                    ->countAllResults();
                                    // ->get()
                                    // ->getResult();

        if ($result > 0) {
            return true;
        } else return false;
    }
}
