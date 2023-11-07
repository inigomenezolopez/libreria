<?php

namespace App\Controllers;

use App\Models\Comic;
use App\Models\Category;
use App\Models\LoginModel;

class FrontPage extends BaseController
{
    public function paginaPrincipal()
    {
        $comicModel = new Comic();

        // Obtiene los IDs de todos los cómics
        $allComicIds = $comicModel->findColumn('id');

        // Selecciona 8 IDs al azar
        $randomComicIds = array_rand(array_flip($allComicIds), 8);

        // Obtiene los detalles de los cómics seleccionados
        $comics = $comicModel->find($randomComicIds);

        // Pasa los cómics a la vista
        return view('paginaprincipal', ['comics' => $comics]);
    }

    public function todosComics()
    {
        $comicModel = new Comic();
        $categoryinfo = new Category();

        $category = $this->request->getGet('category');

        if ($category) {
            $comics = $comicModel->where('category', $category)->paginate(8); // Muestra 8 cómics por página
        } else {
            $comics = $comicModel->paginate(8); // Muestra 8 cómics por página
        }

        $categories = $categoryinfo->findAll();
        $pager = \Config\Services::pager(); // Obtiene el paginador de CodeIgniter

        return view('todosloscomics', ['comics' => $comics, 'categories' => $categories, 'pager' => $pager]);
    }

    public function searchComics()
    {

        $comicModel = new Comic();
        $categoryinfo = new Category();
        $title = $this->request->getGet('title');
        $comics = $comicModel->searchByTitle($title); // Utiliza el método 'searchByTitle()' de tu modelo
        $categories = $categoryinfo->findAll();
        $pager = \Config\Services::pager(); // Obtiene el paginador de CodeIgniter

        // Pasa los cómics, las categorías y el paginador a la vista
        return view('search-comics', ['comics' => $comics, 'categories' => $categories, 'pager' => $pager]);
    }

    public function comicDetails($id)
{
    $comicModel = new Comic();

    // Obtiene los detalles del cómic por ID
    $comic = $comicModel->find($id);

    // Pasa el cómic a la vista
    return view('comic-details', ['comic' => $comic]);
}

public function latestComics()
{
    $model = new Comic();
    $data['latestComics'] = $model->orderBy('created_at', 'DESC')->findAll(6);
    return view('latestComics', $data);
}

public function categories()
{
    $categoryModel = new Category();
    $data['categories'] = $categoryModel->getCategories();
    return view('categories', $data);
}

public function category($categoryId)
{
    $comicModel = new Comic();
    $data['comics'] = $comicModel->getComicsByCategory($categoryId);
    return view('category', $data);
}



public function perfil() {
    $loginModel = new LoginModel();
    
    // Asume que el ID del usuario está almacenado en la sesión
    $id = session()->get('user')['id'];
    
    // Busca los datos del usuario en la base de datos
    $user = $loginModel->find($id);
    
    // Carga la vista de perfil y pasa los datos del usuario
    return view('perfil', ['user' => $user]);
}

public function actualizar_perfil() {
    $loginModel = new LoginModel();

    // Asume que el ID del usuario está almacenado en la sesión
    $id = session()->get('user')['id'];
    
    $name = $this->request->getVar('name');
    $password = $this->request->getVar('password');
    $bio = $this->request->getVar('bio');

    $data = [
        'name' => $name,
        'bio' => $bio
    ];

    // Solo actualiza la contraseña si el usuario ha introducido una nueva
    if (!empty($password)) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    $loginModel->update($id, $data);

    // Establece un mensaje de éxito en la sesión
    session()->setFlashdata('success', 'Datos actualizados correctamente');

    return redirect()->to('/perfil');
}

public function logout() {
    session()->destroy();
    return redirect()->to('/');
}



}
