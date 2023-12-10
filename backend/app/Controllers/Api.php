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
        // $nama = $this->request->getPost('nama');
        // $umur = $this->request->getPost('umur');
        // $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        // $kelas = $this->request->getPost('kelas');
        // $nama = $this->request->getJSON()->nama;
        $umur = $this->request->getJSON()->umur;
        $jenis_kelamin = $this->request->getJSON()->jenis_kelamin;
        $kelas = $this->request->getJSON()->kelas;
        
        
        // Simpan data siswa ke tabel 'siswa'
        $siswaModel = new SiswaModel();
        $number = 1;
        $siswapre_id = 'S';
        // Memeriksa ID kasus sampai ditemukan yang tersedia
        while ($siswaModel->CekId($siswapre_id.$number)){
            $number++;
            $id_siswa = $siswapre_id.$number;
        }
        // Set variabel data untuk input ke database
        $data_siswa = [
            'id_siswa' => $id_siswa,
            //'nama' => $nama,
            'umur' => $umur,
            'jenis_kelamin' => $jenis_kelamin,
            'kelas' => $kelas,
        ];
        $siswaModel->insert($data_siswa);
        
        // Ambil ID siswa yang baru saja dimasukkan ke tabel `siswa`
        $kasusModel = new KasusModel();
        $number = 1;
        $kasuspre_id = 'K';

        // Memeriksa ID kasus sampai ditemukan yang tersedia
        while ($kasusModel->CekId($kasuspre_id.$number)){
            $number++;
            $id_kasus = $kasuspre_id.$number;
        }
        // Set variabel data untuk input ke database
        $data_kasus = [
            'id_kasus' => $id_kasus,
            'id_siswa' => $id_siswa,
        ];
        $kasusModel->insert($data_kasus);
        
        // Simpan pilihan pernyataan ke dalam tabel 'pernyataan_siswa'
        $pernyataanSiswaModel = new PernyataanSiswaModel();
        // $jawaban = $this->request->getPost('jawaban');
        $jawaban = $this->request->getJSON()->jawaban;
        $number = 1;
        $psiswapre_id = 'P';
        // Memeriksa ID kasus sampai ditemukan yang tersedia
        while ($pernyataanSiswaModel->CekId($psiswapre_id.$number)){
            $number++;
            $id_psiswa = $psiswapre_id.$number;
        }
        if (!empty($jawaban)) {
            foreach ($jawaban as $jawab) {
                $data_pernyataansiswa = [
                    'id_pernyataansiswa' => $id_psiswa,
                    'id_kasus' => $id_kasus,
                    'id_pernyataan' => $jawab
                ];
                $number++;
                $id_psiswa = $psiswapre_id.$number;
                $pernyataanSiswaModel->insert($data_pernyataansiswa);
            }
        }
    }
}
