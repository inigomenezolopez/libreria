<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;

class AdminController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle'=>'Dashboard',
        ];
        return view('backend/pages/home', $data);
    }

    public function logoutHandler() {
        CIAuth::forget();
        return redirect()->route('admin.login.form')->with('fail', 'Has cerrado sesión.');
    }
}
