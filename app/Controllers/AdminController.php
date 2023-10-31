<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Models\LoginModel;
use App\Libraries\Hash;
use App\Models\Category;
use SSP;

class AdminController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
    protected $db;
    public function __construct()
    {
        require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
    }
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

        $upload_image = \Config\Services::image()->withFile($file)->resize(450, 450, true, 'height')->save($path . '/' . $new_filename);

        if ($upload_image) {
            if ($old_picture != null && file_exists($path . '/' . $new_filename)) {
                unlink($path . '/' . $old_picture);
            }
            $user->where('id', $user_info->id)->set(['picture' => $new_filename])->update();

            echo json_encode(['status' => 1, 'msg' => 'Tu foto de perfil ha sido actualizada con éxito.']);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Algo salió mal.']);
        }
    }

    public function changePassword()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();
            $user_id = CIAuth::id();
            $user = new LoginModel();
            $user_info = $user->asObject()->where('id', $user_id)->first();

            // validar el formulario
            $this->validate([
                'current_password' => [
                    'rules' => 'required|min_length[5]|check_current_password[current_password]',
                    'errors' => [
                        'required' => 'Introduce la contraseña actual.',
                        'min_length' => 'La contraseña debe tener al menos 5 caracteres',
                        'check_current_password' => 'La contraseña actual es incorrecta.'
                    ]
                ],
                'new_password' => [
                    'rules' => 'required|min_length[5]|max_length[20]|is_password_strong[new_password]',
                    'errors' => [
                        'required' => 'Introduce la nueva contraseña.',
                        'min_length' => 'La contraseña debe tener al menos 5 caracteres',
                        'max_length' => 'La contraseña debe tener como máximo 20 caracteres',
                        'is_password_strong' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un caracter especial.'
                    ]
                ],
                'confirm_new_password' => [
                    'rules' => 'required|matches[new_password]',
                    'errors' => [
                        'required' => 'Confirma la nueva contraseña',
                        'matches' => 'La contraseña introducida no coincide.',
                    ]
                ]

            ]);

            if ($validation->run() === FALSE) {
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $errors]);
            } else {
                // actualizar contraseña del usuario (admin) en la BBDD
                $user->where('id', $user_info->id)->set(['password' => Hash::make($request->getVar('new_password'))])->update();


                return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Hecho.']);
            }
        }
    }
    public function categories()
    {
        $data = [
            'pageTitle' => 'Categorías'
        ];
        return view('backend/pages/categories', $data);
    }

    public function addCategory()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();
            $this->validate([
                'category_name' => [
                    'rules' => 'required|is_unique[category_info.category]',
                    'errors' => [
                        'required' => 'Se requiere una categoría.',
                        'is_unique' => 'El nombre de esta categoría ya existe.'
                    ]
                ]
            ]);
            if ($validation->run() === FALSE) {
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $errors]);
            } else {

                $category = new Category();
                $save = $category->save(['category' => $request->getVar('category_name')]);
                if ($save) {
                    return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Categoría añadida con éxito.']);
                } else {
                    return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Ha habido algún error. Por favor, inténtalo de nuevo.']);
                }
            }
        }
    }

    public function getCategories()
    {
        // detalles de la base de datos
        $dbDetails = array(
            "host" => $this->db->hostname,
            "user" => $this->db->username,
            "pass" => $this->db->password,
            "db" => $this->db->database
        );
        $table = "category_info";
        $primaryKey = "id";
        $columns = array(
            array(
                "db" => "id",
                "dt" => 0
            ),
            array(
                "db" => "category",
                "dt" => 1
            ),
            array(
                "db" => "id",
                "dt" => 2,
                "formatter" => function ($d, $row) {
                    return "<div class='btn-group'>
                    <button class='btn btn-sm btn-link p-0 mx-1 editCategoryBtn' data-id='" . $row['id'] . "'>Editar</button>
                    <button class='btn btn-sm btn-link p-0 mx-1 deleteCategoryBtn' data-id='" . $row['id'] . "'>Borrar</button>
                    </div>";
                }
            ),
        );
        return json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function getCategory()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id = $request->getVar('category_id');
            $category = new Category();
            $category_data = $category->find($id);
            return $this->response->setJSON(['data' => $category_data]);
        }
    }

    public function updateCategory()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $id = $request->getVar('category_id');
            $validation = \Config\Services::validation();

            $this->validate([
                'category_name' => [
                    'rules' => 'required|is_unique[category_info.category,id,' . $id . ']',
                    'errors' => [
                        'required' => 'Se requiere una categoría.',
                        'is_unique' => 'La categoría ya existe en la base de datos.'
                    ]
                ]
            ]);

            if ($validation->run() === FALSE) {
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $errors]);
            } else {
                $category = new Category();
                $update = $category->where('id', $id)->set(['category' => $request->getVar('category_name')])->update();
                if ($update) {
                    return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Categoría actualizada correctamente.']);
                } else {
                    return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Ha ocurrido un error. Inténtalo de nuevo.']);
                }
            }
        }
    }

    public function deleteCategory()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $id = $request->getVar('category_id');
            $category = new Category();
            $delete = $category->where('id', $id)->delete();

            if ($delete) {
                return $this->response->setJSON(['status' => 1, 'msg' => 'Categoría eliminada correctamente.']);
            } else {
                return $this->response->setJSON(['status' => 0, 'msg' => 'Ha ocurrido un error inesperado.']);
            }
        }
    }
}
