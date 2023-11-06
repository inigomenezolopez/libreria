<?php

namespace App\Controllers;

use App\Models\Comic;

class FrontPage extends BaseController
{
    public function index()
    {
        $comicModel = new Comic();

        // Obtiene 8 cómics al azar de la base de datos
        $comics = $comicModel->orderBy('rand()')->limit(8)->findAll();

        // Pasa los cómics a la vista
        return view('paginaprincipal', ['comics' => $comics]);
    }
}

