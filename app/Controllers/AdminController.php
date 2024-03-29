<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Models\LoginModel;
use App\Libraries\Hash;
use App\Models\Category;
use SSP;
use App\Models\Comic;
use App\Models\TransInfo;

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
        $category = new Category();
        $transInfo = new TransInfo();
        $comic = new Comic();
        $user = new LoginModel();
        $db = \Config\Database::connect();

        //total de transacciones
        $query = $db->table('trans_info')->selectSum('price', 'total');
        $result = $query->get()->getResult();
        $total_earnings = round($result[0]->total, 2);

        // comics por categorías
        $builder = $db->table('comic_info');
        $builder->select('category, COUNT(*) as num_comics');
        $builder->groupBy('category');
        $query = $builder->get();





        $data = [
            'pageTitle' => 'Dashboard',
            'num_categories' => $category->countAll(),
            'total_earnings' => $total_earnings,
            'comics_by_category' => $query->getResultArray(),
            'users' => $user->findAll()
        ];
        return view('backend/pages/home', $data);
    }


    public function logoutHandler()
    // Cierra la sesión del usuario y redirige a la página de inicio de sesión. 
    {
        CIAuth::forget();
        return redirect()->route('admin.login.form')->with('fail', 'Has cerrado sesión.');
    }

    public function profile()
    {
        // Muestra la vista del perfil del usuario.
        $data = array(
            'pageTitle' => 'Perfil',
        );
        return view('backend/pages/profile', $data);
    }

    public function updatePersonalDetails()
    {
        // Actualiza los detalles personales del usuario en la base de datos.
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
        // Actualiza la foto de perfil del usuario en la base de datos.
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
        // Cambia la contraseña del usuario en la base de datos.
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
    { // Muestra la vista de las categorías.
        $data = [
            'pageTitle' => 'Categorías'
        ];
        return view('backend/pages/categories', $data);
    }

    public function addCategory()
    { // Añade una nueva categoría a la base de datos.
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
        // Recupera las categorías de la base de datos y las devuelve en formato JSON. SSP facilita la implementación de tablas de datos del lado del servidor.
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
        // coge todas las categorías
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
        // actualizar categorías
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
        // borrar categorias
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

    public function addComic()
    {
        // vista para añadirun nuevo comic y recopila las categorías
        $category = new Category();
        $data = [
            'pageTitle' => 'Añadir nuevo cómic',
            'categories' => $category->asObject()->findAll()
        ];
        return view('backend/pages/new-comic', $data);
    }

    public function createComic()
    { // valida los datos del comic que se está creando, sube y redimensiona la imagen de portada y guarda todos los detalles en la bbdd
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();

            $this->validate([
                'title' => [
                    'rules' => 'required|is_unique[comic_info.title]',
                    'errors' => [
                        'required' => 'Se necesita un título.',
                        'is_unique' => 'Hay otro cómic con el mismo título'
                    ]
                ],
                'price' => [
                    'rules' => 'required|numeric|greater_than[0]',
                    'errors' => [
                        'required' => 'Tienes que poner un precio.',
                        'numeric' => 'Tiene que ser un número.',
                        'greater_than' => 'El precio tiene que ser mayor que 0.'
                    ]
                ],
                'year' => [
                    'rules' => 'required|numeric|greater_than[1900]',
                    'errors' => [
                        'required' => 'Tienes que poner el año de salida.',
                        'numeric' => 'Tiene que ser un número',
                        'greater_than' => 'Tiene que ser un cómic publicado como mínimo en el año 1900.',
                    ]
                ],
                'content' => [
                    'rules' => 'required|min_length[20]',
                    'errors' => [
                        'required' => 'Se necesita una descripción del cómic',
                        'min_length' => 'Tienes que escribir al menos 20 caracteres.'
                    ]
                ],
                'category' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tienes que escoger una categoría.'
                    ]
                ],
                'featured_image' => [
                    'rules' => 'uploaded[featured_image]|is_image[featured_image]',
                    'errors' => [
                        'uploaded' => 'Se necesita una imagen.',
                        'is_image' => 'Selecciona un tipo de imagen.'
                    ]
                ],
            ]);

            if ($validation->run() === FALSE) {
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $errors]);
            } else {
                $path = 'images/comics';
                $file = $request->getFile('featured_image');
                $filename = $file->getRandomName();



                // subir la imagen de portada
                if ($file->move($path, $filename)) {
                    // Obtener la nueva ruta al archivo
                    $newFilePath = $path . '/' . $filename;

                    // Redimensionar la imagen
                    \Config\Services::image()
                        ->withFile($newFilePath)
                        ->resize(300, 417, true, 'height')
                        ->save($path . '/' . $filename);

                    // guardar los detalles del comic
                    $comic = new Comic();
                    $data = array(

                        'title' => $request->getVar('title'),
                        'price' => $request->getVar('price'),
                        'year' =>  $request->getVar('year'),
                        'description' => $request->getVar('content'),
                        'category' => $request->getVar('category'),
                        'picture' => $filename,

                    );
                    $save = $comic->insert($data);

                    if ($save) {
                        return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Cómic añadido correctamente.']);
                    } else {
                        return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Algo ocurrió mal. Inténtalo de nuevo.']);
                    }
                } else {
                    return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Error al subir la portada.']);
                }
            }
        }
    }

    public function allComics()
    { // enseña todos los comics
        $data = [
            'pageTitle' => 'Todos los cómics'
        ];
        return view('backend/pages/all-comics', $data);
    }

    public function getComics()
    {
        // recopila la información de los comics y las devuelven enformato json
        // detalles de la base de datos
        $dbDetails = array(
            "host" => $this->db->hostname,
            "user" => $this->db->username,
            "pass" => $this->db->password,
            "db" => $this->db->database
        );
        $table = "comic_info"; // poner el nombre de mi tabla
        $primaryKey = "id";
        $columns = array(
            array(
                "db" => "id",
                "dt" => 0,
            ),
            array(
                "db" => "id",
                "dt" => 1,
                "formatter" => function ($d, $row) {
                    $comic = new Comic();
                    $image = $comic->asObject()->find($row['id'])->picture;
                    return "<img src='" . base_url("/images/comics/$image") . "' class='img-thumbnail' style='max-width:70px'>";
                }
            ),
            array(
                "db" => "title",
                "dt" => 2,
            ),
            array(
                "db" => "id",
                "dt" => 3,
                "formatter" => function ($d, $row) {
                    $comic = new Comic();
                    $category_id = $comic->asObject()->find($row["id"])->category;
                    return $category_id;
                }
            ),
            array(
                "db" => "id",
                "dt" => 4,
                "formatter" => function ($d, $row) {
                    $comic = new Comic();
                    $price = $comic->asObject()->find($row["id"])->price;
                    return $price;
                }
            ),
            array(
                "db" => "id",
                "dt" => 5,
                "formatter" => function ($d, $row) {
                    $comic = new Comic();
                    $year = $comic->asObject()->find($row["id"])->year;
                    return $year;
                }
            ),
            array(
                "db" => "id",
                "dt" => 6,
                "formatter" => function ($d, $row) {
                    $comic = new Comic();
                    $description = $comic->asObject()->find($row["id"])->description;
                    return $description;
                }
            ),
            array(
                "db" => "id",
                "dt" => 7,
                "formatter" => function ($d, $row) {
                    return "<div class='btn-group'>
                    <a href='" . base_url(route_to('edit-comic', $row['id'])) . "' class='btn btn-sm btn-link p-0 mx-1'>Editar</a>
                    <button class='btn btn-sm btn-link p-0 mx-1 deleteComicBtn' data-id='" . $row['id'] . "'>Borrar</button>
                    </div>";
                }
            ),
        );
        return json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function transInfo()
    {
        // vista para el historial de transacciones
        $data = [
            'pageTitle' => 'Historial de transacciones'
        ];
        return view('backend/pages/transinfo', $data);
    }

    public function getTransInfo()
    { // coge todo el historial de transacciones 
        // detalles de la base de datos
        $dbDetails = array(
            "host" => $this->db->hostname,
            "user" => $this->db->username,
            "pass" => $this->db->password,
            "db" => $this->db->database
        );
        $table = "trans_info"; 
        $primaryKey = "id";
        $columns = array(
            array(
                "db" => "id",
                "dt" => 0,
            ),
            array(
                "db" => "id",
                "dt" => 1,
                "formatter" => function ($d, $row) {
                    $trans = new TransInfo;
                    $email = $trans->asObject()->find($row['id'])->email;
                    return $email;
                }
            ),
            array(
                "db" => "title",
                "dt" => 2,
                "formatter" => function ($d, $row) {
                    $trans = new TransInfo;
                    $title = $trans->asObject()->find($row['id'])->title;
                    return $title;
                }
            ),
            array(
                "db" => "price",
                "dt" => 3,
                "formatter" => function ($d, $row) {
                    $price = new TransInfo;
                    $price_id = $price->asObject()->find($row["id"])->price;
                    return $price_id;
                }
            ),
            array(
                "db" => "created_at",
                "dt" => 4,
                "formatter" => function ($d, $row) {
                    $trans = new TransInfo;
                    $created_at = $trans->asObject()->find($row['id'])->created_at;
                    // Formatear la fecha al formato deseado (día, mes, año)
                    $date = date("d-m-Y", strtotime($created_at));
                    return $date;
                }
            )

        );
        return json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function userInfo()
    { // vista para la lista de usuarios
        $data = [
            'pageTitle' => 'Lista de usuarios'
        ];
        return view('backend/pages/userinfo', $data);
    }

    public function getUserInfo()
    { // coge los detalles del usuario
        // detalles de la base de datos
        $dbDetails = array(
            "host" => $this->db->hostname,
            "user" => $this->db->username,
            "pass" => $this->db->password,
            "db" => $this->db->database
        );
        $table = "userdata"; // poner el nombre de mi tabla
        $primaryKey = "id";
        $columns = array(
            array(
                "db" => "id",
                "dt" => 0,
            ),
            array(
                "db" => "id",
                "dt" => 1,
                "formatter" => function ($d, $row) {
                    $user = new LoginModel;
                    $name = $user->asObject()->find($row['id'])->name;
                    return $name;
                }
            ),
            array(
                "db" => "email",
                "dt" => 2,
                "formatter" => function ($d, $row) {
                    $user = new LoginModel;
                    $email = $user->asObject()->find($row['id'])->email;
                    return $email;
                }
            ),
            array(
                "db" => "created_at",
                "dt" => 3,
                "formatter" => function ($d, $row) {
                    $user = new LoginModel;
                    $created_at = $user->asObject()->find($row['id'])->created_at;
                    // Formatear la fecha al formato deseado (día, mes, año)
                    $date = date("d-m-Y", strtotime($created_at));
                    return $date;
                }
            ),

        );
        return json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function editComic($id)
    { // vista para editar comics
        $comic = new Comic();
        $category = new Category();
        $data = [
            'pageTitle' => 'Editar cómic',
            'comic' => $comic->asObject()->find($id),
            'category' => $category->asObject()->findAll(),
        ];
        return view('backend/pages/edit-comic', $data);
    }

    public function updateComic()
    { // actualiza comics
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();
            $comic_id = $request->getVar('comic_id');
            $user_id = CIAuth::id();
            $comic = new Comic();

            if (isset($_FILES['featured_image']['name']) && !empty($_FILES['featured_image']['name'])) {
                $this->validate([
                    'title' => [
                        'rules' => 'required|is_unique[comic_info.title,id,' . $comic_id . ']',
                        'errors' => [
                            'required' => 'Tienes que escribir un título.',
                            'is_unique' => 'Ya hay otro cómic con el mismo título.'
                        ]
                    ],
                    'price' => [
                        'rules' => 'required|numeric|greater_than[0]',
                        'errors' => [
                            'required' => 'Tienes que poner un precio.',
                            'numeric' => 'Tiene que ser un número.',
                            'greater_than' => 'El precio tiene que ser mayor que 0.'
                        ]
                    ],
                    'year' => [
                        'rules' => 'required|numeric|greater_than[1900]',
                        'errors' => [
                            'required' => 'Tienes que poner el año de salida.',
                            'numeric' => 'Tiene que ser un número',
                            'greater_than' => 'Tiene que ser un cómic publicado como mínimo en el año 1900.',
                        ]
                    ],
                    'content' => [
                        'rules' => 'required|min_length[20]',
                        'errors' => [
                            'required' => 'Se necesita una descripción del cómic',
                            'min_length' => 'Tienes que escribir al menos 20 caracteres.'
                        ]
                    ],
                    'category' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Tienes que escoger una categoría.'
                        ]
                    ],
                    'featured_image' => [
                        'rules' => 'uploaded[featured_image]|is_image[featured_image]',
                        'errors' => [
                            'uploaded' => 'Se necesita una imagen.',
                            'is_image' => 'Selecciona un tipo de imagen.'
                        ]
                    ],



                ]);
            } else {
                $this->validate([
                    'title' => [
                        'rules' => 'required|is_unique[comic_info.title,id,' . $comic_id . ']',
                        'errors' => [
                            'required' => 'Tienes que escribir un título.',
                            'is_unique' => 'Ya hay otro cómic con el mismo título.'
                        ]
                    ],
                    'content' => [
                        'rules' => 'required|min_length[20]',
                        'errors' => [
                            'required' => 'Se necesita una descripción del cómic',
                            'min_length' => 'Tienes que escribir al menos 20 caracteres.'
                        ]
                    ],
                    'year' => [
                        'rules' => 'required|numeric|greater_than[1900]',
                        'errors' => [
                            'required' => 'Tienes que poner el año de salida.',
                            'numeric' => 'Tiene que ser un número',
                            'greater_than' => 'Tiene que ser un cómic publicado como mínimo en el año 1900.',
                        ]
                    ],
                    'category' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Tienes que escoger una categoría.'
                        ]
                    ],
                    'price' => [
                        'rules' => 'required|numeric|greater_than[0]',
                        'errors' => [
                            'required' => 'Tienes que poner un precio.',
                            'numeric' => 'Tiene que ser un número.',
                            'greater_than' => 'El precio tiene que ser mayor que 0.'
                        ]
                    ],
                ]);
            }

            if ($validation->run() === FALSE) {
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $errors]);
            } else {
                // return $this->response->setJSON(['status'=> 1, 'token'=> csrf_hash(), 'msg' => 'Validado.']);
                if (isset($_FILES['featured_image']['name']) && !empty($_FILES['featured_image']['name'])) {
                    $path = 'images/comics';
                    $file = $request->getFile('featured_image');
                    $filename = $file->getRandomName();
                    $old_comic_featured_image = $comic->asObject()->find($comic_id)->picture;

                    // actualizar imagen de portada
                    if ($file->move($path, $filename)) {

                        // redimensionar imagen
                        \Config\Services::image()
                            ->withFile($path . '/' . $filename)
                            ->resize(300, 417, true, 'height')
                            ->save($path . '/' . $filename);

                        // borrar antigua imagen

                        if ($old_comic_featured_image != null && file_exists($path . '/' . $old_comic_featured_image)) {
                            unlink($path . '/' . $old_comic_featured_image);
                        }

                        if (file_exists($path . '/' . $old_comic_featured_image)) {
                            unlink($path . '/' . $old_comic_featured_image);
                        }

                        // actualizar detalles del cómic

                        $data = array(
                            'title' => $request->getVar('title'),
                            'category' => $request->getVar('category'),
                            'description' => $request->getVar('content'),
                            'picture' => $filename,
                            'price' => $request->getVar('price'),
                            'year' => $request->getVar('year'),
                        );

                        $update = $comic->update($comic_id, $data);

                        if ($update) {
                            return $this->response->setJSON(['status' => '1', 'token' => csrf_hash(), 'msg' => 'Cómic actualizado correctamente.']);
                        } else {
                            return $this->response->setJSON(['status' => '0', 'token' => csrf_hash(), 'msg' => 'Algo salió mal.']);
                        }
                    } else {
                        return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Ha ocurrido un error. No se ha podido guardar la imagen de portada.']);
                    }
                } else {
                    // actualizar detalles del comic sin actualizar imagen.
                    $data = array(
                        'title' => $request->getVar('title'),
                        'category' => $request->getVar('category'),
                        'description' => $request->getVar('content'),
                        'price' => $request->getVar('price'),
                        'year' => $request->getVar('year'),
                    );
                    $update = $comic->update($comic_id, $data);
                    if ($update) {
                        return $this->response->setJSON(['status' => '1', 'token' => csrf_hash(), 'msg' => 'Cómic actualizado correctamente.']);
                    } else {
                        return $this->response->setJSON(['status' => '0', 'token' => csrf_hash(), 'msg' => 'Algo salió mal.']);
                    }
                }
            }
        };
    }

    public function deleteComic()
    { // borrar comics
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $id = $request->getVar('comic_id');
            $comic = new Comic();
            $comic_to_delete = $comic->find($id); // Encuentra el cómic que se va a eliminar

            // Intenta eliminar la imagen del cómic del sistema de archivos
            $image_path = 'images/comics' . '/' . $comic_to_delete['picture'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            // Ahora borra el cómic de la base de datos
            $delete = $comic->where('id', $id)->delete();

            if ($delete) {
                return $this->response->setJSON(['status' => 1, 'msg' => 'Cómic eliminado correctamente.']);
            } else {
                return $this->response->setJSON(['status' => 0, 'msg' => 'Ha ocurrido un error inesperado.']);
            }
        }
    }
}
