<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Models\LoginModel;

class AdminController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
    public function index()
    {
        $data = [
            'pageTitle' => 'Dashboard',
        ];
        return view('backend/pages/home', $data);
    }

    public function logoutHandler()
    {
        CIAuth::forget();
        return redirect()->route('admin.login.form')->with('fail', 'Has cerrado sesión.');
    }

    public function profile()
    {
        $data = array(
            'pageTitle' => 'Perfil',
        );
        return view('backend/pages/profile', $data);
    }

    public function updatePersonalDetails()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $user_id = CIAuth::id();

        if ($request->isAJAX()) {
            $this->validate([
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Se requiere un nombre completo.'
                    ]
                ],

            ]);
            if ($validation->run() == FALSE) {
                $errors = $validation->getErrors();
                return json_encode(['status' => 0, 'error' => $errors]);
            } else {
                $user = new LoginModel();
                $update = $user->where('id', $user_id)->set([
                    'name' => $request->getVar('name'),
                    'bio' => $request->getVar('bio'),
                ])->update();

                if ($update) {
                    $user_info = $user->find($user_id);
                    return json_encode(['status' => 1, 'user_info' => $user_info, 'msg' => 'Tus datos personales han sido modificados correctamente.']);
                } else {
                    return json_encode(['status' => 0, 'msg' => 'Ha habido algún error. Por favor, inténtalo de nuevo.']);
                }
            }
        }
    }

    public function updateProfilePicture()
    {
        $request = \Config\Services::request();
        $user_id = CIAuth::id();
        $user = new LoginModel();
        $user_info = $user->asObject()->where('id', $user_id)->first();

        $path = 'images/users';
        $file = $request->getFile('user_profile_file');
        $old_picture = $user_info->picture;
        $new_filename = 'UIMG_' . $user_id . $file->getRandomName();

        $upload_image = \Config\Services::image()->withFile($file)->resize(450, 450, true, 'height')->save($path.'/'.$new_filename);

        if ($upload_image) { 
            if ( $old_picture != null && file_exists($path.'/'.$new_filename)) {
                unlink($path.'/'.$old_picture);
            }
            $user->where('id', $user_info->id)->set(['picture'=>$new_filename])->update();

            echo json_encode(['status'=>1, 'msg'=>'Tu foto de perfil ha sido actualizada con éxito.']);
        } else {
            echo json_encode(['status'=> 0, 'msg'=> 'Algo salió mal.']);
        }


    }
}
