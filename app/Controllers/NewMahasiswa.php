<?php

namespace App\Controllers;


use App\Models\MahasiswaModel;
use CodeIgniter\RESTful\ResourceController;

class NewMahasiswa extends ResourceController
{
    public function index()
    {
        $model = new MahasiswaModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    // get single product
    public function show($id = null)
    {
        $model = new MahasiswaModel();
        $data = $model->getWhere(['product_id' => $id])->getResult();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    // create a product
    public function create()
    {
        $model = new MahasiswaModel();
        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'product_price' => $this->request->getPost('product_price')
        ];
        $data = json_decode(file_get_contents("php://input"));
        //$data = $this->request->getPost();
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];

        return $this->respondCreated($data, 201);
    }

    // update product
    public function update($id = null)
    {
        $model = new MahasiswaModel();
        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'email' => $json->email,
                'nim' => $json->nim,
                'fullname' => $json->fullname,
                'user_image' => $json->user_image
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'email' => $input['email'],
                'nim' => $input['nim'],
                'fullname' => $input['fullname'],
                'user_image' => $input['user_image']
            ];
        }
        // Insert to Database
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }

    // delete product
    public function delete($id = null)
    {
        $model = new MahasiswaModel();
        $data = $model->find($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}
