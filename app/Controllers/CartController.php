<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Comic;
use App\Models\LoginModel;
use App\Models\TransInfo;

class CartController extends Controller
{
    public function add($comicId)
    {
        // Comprueba si el usuario ha iniciado sesión.
        if (!session()->has('user')) {
            // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión.
            return redirect()->to('/login');
        }

        // Obtiene el ID del usuario de la sesión.
        $userId = session()->get('user')['id'];

        // Aquí añades el cómic al carrito del usuario.
        // Puedes usar la sesión para almacenar los cómics en el carrito.
        $cart = [];
        if (session()->has("cart_$userId")) {
            $cart = session()->get("cart_$userId");
        }
        $cart[] = $comicId;
        session()->set("cart_$userId", $cart);

        // Calcula el nuevo total y guárdalo en la sesión.
        $total = session()->get("total_$userId");
        $comicModel = new Comic();
        $comic = $comicModel->find($comicId);
        $total += $comic['price'];
        session()->set("total_$userId", $total);

        // Redirige al usuario a la página del carrito.
        return redirect()->to('/cart');
    }

    public function view()
{
    // Comprueba si el usuario ha iniciado sesión.
    if (!session()->has('user')) {
        // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión.
        return redirect()->to('/login');
    }

    // Obtiene el ID del usuario de la sesión.
    $userId = session()->get('user')['id'];

    // Aquí muestras los cómics en el carrito.
    $cart = [];
    if (session()->has("cart_$userId")) {
        $cart = session()->get("cart_$userId");
    }

    // Obtén los detalles de todos los cómics del modelo Comic.
    $comicModel = new Comic();
    $allComics = [];
    if (!empty($cart)) {
        $allComics = $comicModel->find($cart);
    }

    // Calcula el precio total de todos los cómics en el carrito.
    $total = 0;
    foreach ($allComics as $comic) {
        $total += $comic['price'];
    }

    // Pasa el total a la vista.
    return view('cart', ['comics' => $allComics, 'total' => $total]);
}


    public function remove($comicId)
    {
        // Comprueba si el usuario ha iniciado sesión.
        if (!session()->has('user')) {
            // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión.
            return redirect()->to('/login');
        }

        // Obtiene el ID del usuario de la sesión.
        $userId = session()->get('user')['id'];

        // Aquí quitas el cómic del carrito del usuario.
        if (session()->has("cart_$userId")) {
            $cart = session()->get("cart_$userId");
            if (($key = array_search($comicId, $cart)) !== false) {
                unset($cart[$key]);
            }
            session()->set("cart_$userId", $cart);
        }

        // Calcula el nuevo total y guárdalo en la sesión.
        $total = session()->get("total_$userId");
        $comicModel = new Comic();
        $comic = $comicModel->find($comicId);
        $total -= $comic['price'];
        session()->set("total_$userId", $total);

        // Redirige al usuario a la página del carrito.
        return redirect()->to('/cart');
    }

    public function checkout()
{
    // Comprueba si el usuario ha iniciado sesión.
    if (!session()->has('user')) {
        // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión.
        return redirect()->to('/login');
    }

    // Obtiene el ID del usuario de la sesión.
    $userId = session()->get('user')['id'];

    // Aquí muestras los cómics en el carrito.
    $cart = [];
    if (session()->has("cart_$userId")) {
        $cart = session()->get("cart_$userId");
    }

    // Obtén los detalles de todos los cómics del modelo Comic.
    $comicModel = new Comic();
    $allComics = [];
    if (!empty($cart)) {
        $allComics = $comicModel->find($cart);
    }

    // Calcula el precio total de todos los cómics en el carrito.
    $total = 0;
    foreach ($allComics as $comic) {
        $total += $comic['price'];
    }

    // Obtiene los datos del usuario del modelo LoginModel.
    $loginModel = new LoginModel();
    $user = $loginModel->find($userId);

    // Pasa los cómics, el total y los datos del usuario a la vista.
    return view('checkout', ['comics' => $allComics, 'total' => $total, 'user' => $user]);
}

public function pay()
{
    // Comprueba si el usuario ha iniciado sesión.
    if (!session()->has('user')) {
        // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión.
        return redirect()->to('/login');
    }

    // Obtiene el ID del usuario de la sesión.
    $userId = session()->get('user')['id'];

    // Aquí muestras los cómics en el carrito.
    $cart = [];
    if (session()->has("cart_$userId")) {
        $cart = session()->get("cart_$userId");
    }

    // Obtén los detalles de todos los cómics del modelo Comic.
    $comicModel = new Comic();
    $allComics = [];
    if (!empty($cart)) {
        $allComics = $comicModel->find($cart);
    }

    // Obtiene los datos del usuario del modelo LoginModel.
    $loginModel = new LoginModel();
    $user = $loginModel->find($userId);

    // Crea una nueva instancia del constructor de consultas de la base de datos.
    $db = \Config\Database::connect();

    // Guarda cada cómic en la tabla trans_info.
    foreach ($allComics as $comic) {
        $data = [
            'email' => $user['email'],
            'title' => $comic['title'],
            'price' => $comic['price']
        ];
        $db->table('trans_info')->insert($data);
    }


    

    // Redirige al usuario a una página de confirmación de pago.
    return redirect()->to('/payment-confirmation');
}

public function paymentConfirmation()
{
    // Pasa un mensaje genérico de confirmación a la vista.
    return view('payment_confirmation', ['message' => 'Transacción aceptada. Se enviará un correo electrónico con los detalles de la transacción.']);
}




}
