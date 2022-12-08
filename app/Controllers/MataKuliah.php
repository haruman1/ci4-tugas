<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MataKuliahModel;

class MataKuliah extends BaseController
{
    public function __construct() //sebelum function lainnya dijalankan makaini dijalankan dulu
    {
        $this->mataKuliah = new MataKuliahModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('mataKuliah');
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        helper('form');

        $data = [
            'mataKuliah' => $this->mataKuliah->tampilSiswa(),
        ];
        echo view('viewShowMataKuliah', $data);
    }
}
