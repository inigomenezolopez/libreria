<?php

namespace App\Controllers;

use App\Models\LoginModel;


class Login extends BaseController
{
    public function index()
    {
        helper(['form']);
        return view('login');
    }

    public function login_form()
    {
        helper(['form']);
        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'El correo electrónico es requerido.',
                    'valid_email' => 'Por favor, introduce una dirección de correo electrónico válida.',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La contraseña es requerida.',
                ]
            ]
        ];

        if ($this->validate($rules)) {
            $loginModel = new LoginModel();
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $result = $loginModel->where('email', $email)->first();

            if ($result != null) {

                // Verificar la contraseña hasheada
                if (password_verify($password, $result['password'])) {
                    $this->session->set('user', ['id' => $result['id'], 'name' => $result['name']]);
                    $this->session->set('isLoggedIn', true);
                    $userId = $result['id'];
                    $this->session->set("comicCount_$userId", 0);
                    return redirect()->to('/');
                } else {
                    return redirect()->to('/login')->with('error', 'Usuario o contraseña incorrectos.')->withInput();
                }
            } else {
                return redirect()->to('/login')->with('error', 'Usuario o contraseña incorrectos.')->withInput();
            }
        } else {
            $data['validation'] = $this->validator;
            echo view('login', $data);
        }
    }
}