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
    
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
    
        $result = $loginModel->where('email', $email)->first();
    
        if ($result['id'] > 0) {
            // Verifica la contraseña hasheada
            if (password_verify($password, $result['password'])) {
                
                $this->session->set('user', ['id' => $result['id'], 'name' => $result['name']]);
                $this->session->set('isLoggedIn', true);
    
                return redirect()->to('/');
        
            } else {
                return redirect()->to('/login')->with('error', 'Usuario o contraseña incorrectos.');
            }
        } else {
            return redirect()->to('/login')->with('error', 'Usuario o contraseña incorrectos.');
        }
    }
    
}