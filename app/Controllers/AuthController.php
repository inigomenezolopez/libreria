<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\LoginModel;
use App\Models\PasswordResetToken;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail'];
    public function loginForm()
    {
        $data = [
            'pageTitle' => 'Login',
            'validation' => null
        ];
        return view('backend/pages/auth/authlogin', $data);
    }

    public function loginHandler()
    {
        // Cargar el modelo
        $model = new LoginModel();

        $isValid = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[userdata.email]',
                'errors' => [
                    'required' => 'Se requiere un email.',
                    'valid_email' => 'Por favor, comprueba de nuevo tu correo. No parece ser válido.',
                    'is_not_unique' => 'El email no está registrado en nuestro sistema.',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Se requiere una contraseña.',
                    'min_length' => 'La contraseña tiene que tener más de 5 caracteres.'
                ]
            ],
        ]);

        if (!$isValid) {
            return view('backend/pages/auth/authlogin', [
                'pageTitle' => 'Login',
                'validation' => $this->validator
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
                return view('backend/pages/auth/authlogin', [
                    'pageTitle' => 'Login',
                    'validation' => 'Usuario o contraseña incorrectos'
                ]);
            }
        }
    }
    public function forgotForm()
    {
        $data = array(
            'pageTitle' => 'Olvidó su contraseña',
            'validation' => null,
        );
        return view('backend/pages/auth/forgot', $data);
    }

    public function sendPasswordResetLink()
    {

        $isValid = $this->validate([

            'email' => [
                'rules' => 'required|valid_email|is_not_unique[userdata.email]',
                'errors' => [
                    'required' => 'Se necesita un email.',
                    'valid_email' => 'Introduce un email válido.',
                    'is_not_unique' => 'El email no está registrado en nuestro sistema.',
                ],
            ]
        ]);

        if (!$isValid) {
            return view('backend/pages/auth/forgot', [
                'pageTitle' => 'Se olvidó su contraseña',
                'validation' => $this->validator,
            ]);
        } else {
            // Get user (admin) details
            $user = new LoginModel;
            $user_info = $user->asObject()->where('email', $this->request->getVar('email'))->first();

            // generate token

            $token = bin2hex(openssl_random_pseudo_bytes(65));

            // get reset password token

            $password_reset_token = new PasswordResetToken();
            $isOldTokenExists = $password_reset_token->asObject()->where('email', $user_info->email)->first();

            if ($isOldTokenExists) {
                // update existing token
                $password_reset_token->where('email', $user_info->email)->set(['token' => $token, 'created_at' => Carbon::now()])->update();
            } else {
                $password_reset_token->insert([
                    'email' => $user_info->email,
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);
            }

            // create action link
            $actionLink = base_url(route_to('admin.reset-password', $token));

            $mail_data = array(
                'actionLink' => $actionLink,
                'user' => $user_info,

            );

            $view = \Config\Services::renderer();
            $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/forgot-email-template');



            $mailConfig = array(
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => $user_info->email,
                'mail_recipient_name' => $user_info->name,
                'mail_subject' => 'Restablecer contraseña',
                'mail_body' => $mail_body
            );

            //send email
            if (sendEmail($mailConfig)) {
                return redirect()->route('admin.forgot.form')->with('success', 'Te hemos enviado un email con el enlace para restablecer la contraseña.');
            } else {
                return redirect()->route('admin.forgot.form')->with('error', 'Ha habido algún error. Inténtalo de nuevo. ');
            }
        }
    }

    public function resetPassword($token)
    {
        $passwordResetPassword = new PasswordResetToken();
        $check_token = $passwordResetPassword->asObject()->where('token', $token)->first();

        if (!$check_token) {
            return redirect()->route('admin.forgot.form')->with('fail', 'Token inválido. Por favor, solicita de nuevo restablecer tu contraseña.');
        } else {
            // comprobar si no se ha expirado (menos de 15 min)
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            if ($diffMins > 15) {
                // si el token ha expirado (más de 15 min)
                return redirect()->route('admin.forgot.form')->with('fail', 'El token ha expirado. Por favor, solicita de nuevo restablecer tu contraseña');
            } else {
                return view('backend/pages/auth/reset', [
                    'pageTitle' => 'Restablecer contraseña',
                    'validation' => null,
                    'token' => $token
                ]);
            }
        }
    }

    public function resetPasswordHandler($token)
    {
        $isValid = $this->validate([
            'new_password' => [
                'rules' => 'required|min_length[5]|max_length[20]|is_password_strong[new_password]',
                'errors' => [
                    'required' => 'Introduce una nueva contraseña.',
                    'min_length' => 'Por favor, introduce más de 5 caracteres.',
                    'max_length' => 'El máximo son 20 caracteres.',
                    'is_password_strong' => 'La nueva contraseña debe de contener al menos una mayúscula, una minúscula, un número y un caracter especial.',
                ]
            ],
            'confirm_new_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Introduce otra vez la nueva contraseña.',
                    'matches' => 'Las contraseñas que has introducido no coinciden.',
                ],
            ]
        ]);

        if (!$isValid) {
            return view('backend/pages/auth/reset', [
                'pageTitle' => 'Restablecer contraseña',
                'validation' => null,
                'token' => $token,
            ]);
        } else {
            // conseguir detalles del token
            $passwordResetPassword = new PasswordResetToken();
            $get_token = $passwordResetPassword->asObject()->where('token', $token)->first();

            //conseguir detalles del usuario (admin)
            $user = new LoginModel();
            $user_info = $user->asObject()->where('email', $get_token->email)->first();

            if (!$get_token) {
                return redirect()->back()->with('fail', 'Token inválido.')->withInput();
            } else {
                // actualizar la contraseña del admin en la BBDD
                $user->where('email', $user_info->email)
                    ->set(['password' => Hash::make($this->request->getVar('new_password'))])
                    ->update();
                // enviar notificación al usuario (admin) mediante email
                $mail_data = array(
                    'user' => $user_info,
                    'new_password' => $this->request->getVar('new_password')
                );

                $view = \Config\Services::renderer();
                $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/password-changed-email-template');

                $mailConfig = array(
                    'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name' => env('EMAIL_FROM_NAME'),
                    'mail_recipient_email' => $user_info->email,
                    'mail_recipient_name' => $user_info->name,
                    'mail_subject' => 'Contraseña cambiada',
                    'mail_body' => $mail_body
                );

                if (sendEmail($mailConfig)) {
                    // eliminar token
                    $passwordResetPassword->where('email', $user_info->email)->delete();

                    // redireccionar y mostrar mensaje en página de login

                    return redirect()->route('admin.login.form')->with('success', 'Tu contraseña ha sido cambiada con éxito');
                } else {
                    return redirect()->back()->with('fail', 'Ha ocurrido un error inesperado. Inténtalo de nuevo.')->withInput();
                }
            }
        }
    }
}
