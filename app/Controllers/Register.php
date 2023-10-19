<?php

namespace App\Controllers;
class Register extends BaseController
{
   
    public function index()
    {
        return view('register');
    }

    public function guardar()
    {
    $correo = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    $password2 = $this->request->getPost('password2');

    var_dump($correo);
    }
}