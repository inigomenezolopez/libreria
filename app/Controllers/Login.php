<?php

namespace App\Controllers;
use App\Models\LoginModel;
class Login extends BaseController
{
   
    public function index()
    {
        return view('login');
    }

    public function login_form() {
        $loginModel = new LoginModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $result = $loginModel->where('email', $email)->first();


        if ($result['id'] > 0) {
                if ($password == $result['password']) {
                    
                    $this->session->set("name", $result);

                    return redirect()->to('http://localhost/libreria/public/');
            
            } else{
            echo 'Usuario o contraseña incorrectos.';
            }
        } else {
            echo 'Usuario o contraseña incorrectos.';
        }

    }
}