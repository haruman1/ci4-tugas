<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MahasiswaModel;

class Mahasiswa extends ResourceController
{
    protected $mahasiswaModel, $db, $builder;
    protected $format = 'json';
    public function __construct() //sebelum function lainnya dijalankan makaini dijalankan dulu
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('mahasiswa');
        $this->validation = \Config\Services::validation();
    }
    public function index($id_mahasiswa = null)
    {
        $count = $id_mahasiswa == null ? $this->builder->countAll() : $this->builder->where('id', $id_mahasiswa)->countAllResults();
        $data = [
            'status' => 200,
            'count' => $count,
            'data' => $this->mahasiswaModel->getMahasiswa($id_mahasiswa)
        ];

        if ($id_mahasiswa == null) {
            return $this->response->setJSON($data, 200);
        };
        if ($count == 0) {
            $this->response->setStatusCode(404);
            $data = [
                'statusCode' => 404,
                'status' => 'failed',
                'message' => "Data mahasiswa dengan id $id_mahasiswa tidak ditemukan"
            ];
            return $this->response->setJSON($data, 404);
        } else {
            return $this->response->setJSON($data, 200);
        }
    }
    public function create()
    {

        if (!$this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_unique[mahasiswa.email.id,{id}]',
                'errors' => [
                    'required' => '{field} mahasiswa harus diisi.',
                    'valid_Email' => 'Format {$field} mahasiswa tidak valid.',

                ],
            ],
            'nim' => [
                'rules' => 'required|is_unique[mahasiswa.email.id,{id}]|max_length[7]',
                'errors' => [
                    'required' => '{field} mahasiswa harus diisi.',
                    'is_unique' => '{field} tidak boleh sama.',
                    'max_length' => '{field} maksimal 7 karakter.',
                ],
            ],
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} mahasiswa harus diisi.',

                ],
            ],
            'userImage' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} mahasiswa harus diisi.',
                ],
            ],
        ])) {
            $this->response->setStatusCode(400);
            $data = [
                'statusCode' => 400,
                'status' => 'fail',
                'messages' => $this->validation->getErrors(),
            ];
            return $this->response->setJSON($data);
        }
        $return = $this->mahasiswaModel->save([
            'email' => $this->request->getVar('email'),
            'nim' => $this->request->getVar('nim'),
            'fullname' => $this->request->getVar('fullname'),
            'user_image' => $this->request->getVar('userImage'),
        ]);
        $this->response->setStatusCode(200);
        $data = [
            'statusCode' => 200,
            'status' => 'success',
            'messages' => 'Data Mahasiswa berhasil ditambahkan',
            'data' => $return,
        ];
        return $this->response->setJSON($data);
    }
    public function remove($id_mahasiswa = null)
    {
        $count = $this->builder->where('id', $id_mahasiswa)->countAllResults();
        if ($count == 0) {
            $this->response->setStatusCode(404);
            $data = [
                'statusCode' => 404,
                'status' => 'failed',
                'message' => "Data mahasiswa dengan id $id_mahasiswa tidak ditemukan"
            ];
            return $this->response->setJSON($data, 404);
        } else {
            $this->builder->delete(['id' => $id_mahasiswa]);
            $this->response->setStatusCode(200);
            $data = [
                'statusCode' => 200,
                'status' => 'success',
                'message' => "Data mahasiswa dengan id $id_mahasiswa berhasil dihapus"
            ];
            return $this->response->setJSON($data, 200);
        }
    }
}
