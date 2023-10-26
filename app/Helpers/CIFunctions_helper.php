<?php

use App\Libraries\CIAuth;
use App\Models\LoginModel;


if (!function_exists("get_user")) {
    function get_user(){
        if (CIAuth::check()) {
            $user = new LoginModel();
            return $user->asObject()->where('id', CIAuth::id())->first();
        } else {
            return null;
        }
    }
}