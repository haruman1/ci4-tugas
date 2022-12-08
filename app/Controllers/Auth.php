<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
    }


    public function index()
    {
        $data = [
            'title' => 'Login',
            'validation' => $this->validation,
        ];
        return view('auth/login', $data);
    }
    public function __login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $this->db->table('auth')->where('email', $email)->get()->getRowArray();
        if ($data) {
            if (password_verify($password, $data['password'])) {
                $data = [
                    'id_user' => $data['id_user'],
                    'email' => $data['email'],
                    'username_user' => $data['username_user'],
                    'fullname' => $data['fullname'],
                    'user_image' => $data['user_image'],
                    'daftar_waktu' => $data['daftar_waktu'],
                    'logged_in' => true,
                ];
                session()->set($data);
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata('pesan', 'Password salah');
                return redirect()->to('/auth');
            }
        } else {
            session()->setFlashdata('pesan', 'Email tidak terdaftar');
            return redirect()->to('/auth');
        }
    }
    public function register()
    {
        $data = [
            'title' => 'Register',
            'validation' => $this->validation,
        ];
        return view('auth/register', $data);
    }
    public function __register()
    {
        $email = $this->request->getVar('email');
        $username_user = $this->request->getVar('username_user');
        $password = $this->request->getVar('password');
        $fullname = $this->request->getVar('fullname');
        $user_image = $this->request->getVar('user_image');
        $daftar_waktu = $this->request->getVar('daftar_waktu');
        $data = [
            'email' => $email,
            'username_user' => $username_user,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'fullname' => $fullname,
            'user_image' => $user_image,
            'daftar_waktu' => $daftar_waktu,
        ];
        $this->db->table('auth')->insert($data);
        session()->setFlashdata('pesan', 'Berhasil mendaftar');
        return redirect()->to('/auth');
    }
    public function lupa_password()
    {
        $data = [
            'title' => 'Lupa Password',
            'validation' => $this->validation,
        ];
        return view('auth/lupa_password', $data);
    }
    public function __forget_pw()
    {
        $email = $this->request->getVar('email');
        $data = $this->db->table('auth')->where('email', $email)->get()->getRowArray();
        if ($data) {
            $data = [
                'id_user' => $data['id_user'],
                'email' => $data['email'],
                'username_user' => $data['username_user'],
                'fullname' => $data['fullname'],
                'user_image' => $data['user_image'],
                'daftar_waktu' => $data['daftar_waktu'],
                'logged_in' => true,
            ];
            session()->set($data);
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('pesan', 'Email tidak terdaftar');
            return redirect()->to('/auth');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
    public function __reset_pw()
    {
        $password = $this->request->getVar('password');
        $data = [
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
        $this->db->table('auth')->where('id_user', session()->get('id_user'))->update($data);
        session()->setFlashdata('pesan', 'Berhasil mereset password');
        return redirect()->to('/auth');
    }
    public function verification()
    {
        $data = [
            'title' => 'Verifikasi',
            'validation' => $this->validation,
        ];
        return view('auth/verification', $data);
    }
    public function __verif()
    {
        $email = $this->request->getVar('email');
        $data = $this->db->table('auth')->where('email', $email)->get()->getRowArray();
        if ($data) {
            $data = [
                'id_user' => $data['id_user'],
                'email' => $data['email'],
                'username_user' => $data['username_user'],
                'fullname' => $data['fullname'],
                'user_image' => $data['user_image'],
                'daftar_waktu' => $data['daftar_waktu'],
                'logged_in' => true,
            ];
            session()->set($data);
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('pesan', 'Email tidak terdaftar');
            return redirect()->to('/auth');
        }
    }
}
