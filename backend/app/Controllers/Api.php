<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BaseCaseModel;
use App\Models\SiswaModel;
use App\Models\PernyataanSiswaModel;
use App\Models\PernyataanModel;
use App\Models\KasusModel;
use App\Models\MinatBakatModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        $basecmodel = new BaseCaseModel();
        $kasusmodel = new KasusModel();
        $siswamodel = new SiswaModel();
        $pernyataanmodel = new PernyataanModel();
        $psiswamodel = new PernyataanSiswaModel();
        $minatbakatmodel = new MinatBakatModel();

        // Set value data yang dikirim untuk reply / 
        // Menentukan query parameter yang diterima
        $params = $this->request->getGet();

        // Set value data yang dikirim untuk reply / respond
        $data = [];

        // Memeriksa setiap parameter dan memuat data yang sesuai
        if (empty($params)){
            $data = [
                'base_case' => $basecmodel->GetCaseBasePernyataan(),
                'kasus' => $kasusmodel->GetKasus(),
                'siswa' => $siswamodel->GetSiswa(),
                'pernyataan' => $pernyataanmodel->GetPernyataan(),
                'pernyataan siswa' => $psiswamodel->GetPernyataanSiswa()
            ];
        } else {
            foreach ($params as $param => $value) {
                switch ($param) {
                    case 'base_case':
                        $data['base_case'] = $basecmodel->GetCaseBasePernyataan();
                        break;
                    case 'kasus':
                        $data['kasus'] = $kasusmodel->GetKasus();
                        break;
                    case 'siswa':
                        $data['siswa'] = $siswamodel->GetSiswa();
                        break;
                    case 'pernyataan':
                        $data['pernyataan'] = $pernyataanmodel->GetPernyataan();
                        break;
                    case 'pernyataan_siswa':
                        $data['pernyataan_siswa'] = $psiswamodel->GetPernyataanSiswa();
                        break;
                    case 'minat_bakat':
                        $data['minat_bakat'] = $minatbakatmodel->GetMinatBakat();
                        break;
                    default:
                        break;
                }
            }
        }
        // Respon ke Request
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    public function create()
    {

        header('Access-Control-Allow-Origin: *');
        // Ambil data mahasiswa dari form
        $nama = $this->request->getPost('nama');
        $umur = $this->request->getPost('umur');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $kelas = $this->request->getPost('kelas');

        // Ambil input dari form
        $data_siswa['umur'] = $this->request->getJSON()->umur;
        $data_siswa['jenis_kelamin'] = $this->request->getJSON()->jenis_kelamin;
        $data_siswa['kelas'] = $this->request->getJSON()->kelas;

        // Simpan data siswa ke tabel 'siswa'
        $siswaModel = new SiswaModel();
        $siswaModel->insertData($data_siswa);
        $id_siswa = $siswaModel->getInsertID(); // Ambil ID siswa yang baru saja dimasukkan ke tabel `siswa`
        
        // Tambah kasus baru ke tabel 'kasus'
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

        $basecmodel = new BaseCaseModel();
        $baseCase = $basecmodel->GetCaseBasePernyataan();

        $sdc = sdc($data_pernyataansiswa['id_pernyataan'], $baseCase);

        // Set data Respond
        $data = [
            'msg' => 'Berhasil~!',
            'id_siswa' => $id_siswa,
            'id_kasus' => $id_kasus,
            'umur' => $data_siswa['umur'],
            'jenis_kelamin' => $data_siswa['jenis_kelamin'],
            'kelas' => $data_siswa['kelas'],
            'hasil_sdc' => $sdc,
        ];

        $kasusModel->where('id_kasus', $id_kasus)->set('id_minatbakat', $sdc[0]['id_minatbakat'])->update();

        // Respon ke Request
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Tidak berhasil.');
        }
    }
}