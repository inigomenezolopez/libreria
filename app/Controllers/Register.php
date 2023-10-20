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
       $name = $this->request->getPost('name');
       $email = $this->request->getPost('email');
       $password = $this->request->getPost('password');

       

       $data = ['name' => $name,'email'=> $email,'password'=> $password];

       $r = $registroModel->insert($data);

       if($r){
        return redirect()->to('/success');
       }
       else{
        echo "Error en el registro. Inténtalo de nuevo.";
       }




        
    }
}