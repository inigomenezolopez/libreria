<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\LoginModel;
class AuthController extends BaseController
{
    protected $helpers = ['url', 'form'];
    public function loginForm()
    {
        $data = [
            'pageTitle' => 'Login',
            'validation' => null
        ];
        return view('backend/pages/auth/authlogin', $data);
    }

    public function loginHandler(){
        // Cargar el modelo
        $model = new LoginModel();
    
        $isValid = $this->validate([
            'email'=>[
                'rules'=>'required|valid_email',
                'errors'=> [
                    'required'=>'Se requiere un email.',
                    'valid_email'=>'Por favor, comprueba de nuevo tu correo. No parece ser válido.'
                    ]
            ],
            'password'=>[
                'rules'=>'required|min_length[5]',
                'errors'=> [
                    'required'=> 'Se requiere una contraseña.',
                    'min_length'=> 'La contraseña tiene que tener más de 5 caracteres.'
                ]
            ],
        ]);
    
        if (!$isValid) {
            return view('backend/pages/auth/authlogin',[
                'pageTitle'=>'Login',
                'validation'=>$this->validator
            ]);
        } else {
            // Buscar el usuario en la base de datos
            $user = $model->where('email', $this->request->getPost('email'))->first();
            $password = $this->request->getPost('password') ?? '';
    
            // Verificar si el usuario existe y si la contraseña es correcta
            if ($user && Hash::check($password, $user['password'])) {
                // El usuario existe y la contraseña es correcta
                CIAuth::setCIAuth($user);
                return redirect()->route('admin.home'); 
            } else {
                // El usuario no existe o la contraseña es incorrecta
                return view('backend/pages/auth/authlogin',[
                    'pageTitle'=>'Login',
                    'validation'=>'Usuario o contraseña incorrectos'
                ]);
            }
        }
    }
    
    
    
    

    

}
