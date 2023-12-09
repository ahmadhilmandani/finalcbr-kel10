<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BaseCaseModel;
use App\Models\KasusModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $basecmodel = new BaseCaseModel();

        $data = [
            'base case' => $basecmodel->GetKasus()
        ];
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
}
