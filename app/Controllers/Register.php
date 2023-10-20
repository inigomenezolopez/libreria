<?php

namespace App\Controllers;
use App\Models\RegistroModel;
class Register extends BaseController
{
   
    public function index()
    {
        return view('register');
    }
    public function success(){
        return view('success');
    }
    public function guardar()
    {
        $registroModel = new RegistroModel();
        $registroModel->insert([
            'name'=>$this->request->getPost('name'),
            'email'=>$this->request->getPost('email'),
            'password'=>$this->request->getPost('password'),
        ]);

        // Redirigir al usuario a la página de éxito
        return redirect()->to('/success');
    }
}