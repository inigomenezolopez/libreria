<?php

namespace App\Controllers;

use App\Models\RegistroModel;

class Register extends BaseController
{
    public function index()
    {
        return view('register');
    }
    public function guardar()
{
    helper(['form']);
    $rules = [
        'name' => [
            'rules' => 'required|min_length[3]|max_length[20]',
            'errors' => [
                'required' => 'El nombre es requerido.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede tener más de 20 caracteres.'
            ]
        ],
        'email' => [
            'rules' => 'required|min_length[6]|max_length[100]|valid_email|is_unique[userdata.email]',
            'errors' => [
                'required' => 'El correo electrónico es requerido.',
                'min_length' => 'El correo electrónico debe tener al menos 6 caracteres.',
                'max_length' => 'El correo electrónico no puede tener más de 50 caracteres.',
                'valid_email' => 'Por favor, introduce una dirección de correo electrónico válida.',
                'is_unique' => 'Este correo electrónico ya está registrado.'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[5]|max_length[20]',
            'errors' => [
                'required' => 'La contraseña es requerida.',
                'min_length' => 'La contraseña debe tener al menos 5 caracteres.',
                'max_length' => 'La contraseña no puede tener más de 20 caracteres.'
            ]
        ]
    ];

    if ($this->validate($rules)) {
        $registroModel = new RegistroModel();
        $name = $this->request->getVar('name');
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Hashea la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $data = ['name' => $name, 'email' => $email, 'password' => $hashed_password];

        $r = $registroModel->insert($data);

        if ($r) {
            session()->setFlashdata('success', 'Registrado correctamente. Ahora puedes iniciar sesión.');
            return redirect()->to('/login');
        } else {
            echo "Error en el registro. Inténtalo de nuevo.";
        }
    } else {
        $data['validation'] = $this->validator;
        echo view('register', $data);
    }
}

}
