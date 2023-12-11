<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BaseCaseModel;
use App\Models\SiswaModel;
use App\Models\PernyataanSiswaModel;
use App\Models\PernyataanModel;
use App\Models\KasusModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $basecmodel = new BaseCaseModel();
        $kasusmodel = new KasusModel();
        $siswamodel = new SiswaModel();
        $pernyataanmodel = new PernyataanModel();
        $psiswamodel = new PernyataanSiswaModel();

        // Set value data yang dikirim untuk reply / respond
        $data = [
            'base case' => $basecmodel->GetCaseBase(),
            'kasus' => $kasusmodel->GetKasus(),
            'siswa' => $siswamodel->GetSiswa(),
            'pernyataan' => $pernyataanmodel->GetPernyataan(),
            'pernyataan siswa' => $psiswamodel->GetPernyataanSiswa()
        ];

        // Respon ke Request
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    public function create()
    {
        // Ambil data siswa dari form
        $data_siswa['umur'] = $this->request->getJSON()->umur;
        $data_siswa['jenis_kelamin'] = $this->request->getJSON()->jenis_kelamin;
        $data_siswa['kelas'] = $this->request->getJSON()->kelas;
        
        // Simpan data siswa ke tabel 'siswa'
        $siswaModel = new SiswaModel();
        $siswaModel->insertData($data_siswa);
        $id_siswa = $siswaModel->getInsertID(); // Ambil ID siswa yang baru saja dimasukkan ke tabel `siswa`
        
        $kasusModel = new KasusModel();
        $data_kasus['id_siswa'] = $id_siswa;
        $kasusModel->insertData($data_kasus);
        $id_kasus = $kasusModel->getInsertID();
        
        // Simpan pilihan pernyataan ke dalam tabel 'pernyataan_siswa'
        $pernyataanSiswaModel = new PernyataanSiswaModel();
        $data_pernyataansiswa['id_pernyataan'] = $this->request->getJSON()->id_pernyataan;
        $data_pernyataansiswa['id_kasus'] = $id_kasus;
        $pernyataanSiswaModel->insertData($data_pernyataansiswa);
        //$id_pernyataansiswa = $pernyataanSiswaModel->getInsertID();

        $data = [
            'msg' => 'Berhasil~!',
            'id_siswa' => $id_siswa,
            'id_kasus' => $id_kasus,
        ];
        
        // Respon ke Request
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak berhasil.');
        }
    }
}
