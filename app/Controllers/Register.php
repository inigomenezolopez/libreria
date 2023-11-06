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
       $name = $this->request->getVar('name');
       $email = $this->request->getVar('email');
       $password = $this->request->getVar('password');

       // Hashea la contraseña
       $hashed_password = password_hash($password, PASSWORD_DEFAULT);

       $data = ['name' => $name,'email'=> $email,'password'=> $hashed_password];

       $r = $registroModel->insert($data);

       if($r){
        return redirect()->to('/success');
       }
       else{
        echo "Error en el registro. Inténtalo de nuevo.";
       }
    }
}
