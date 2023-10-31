<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/register', 'Register::index');

$routes->post('/register', 'Register::guardar');

$routes->get('/success', 'Register::success');


$routes->get('/login', 'Login::index');

$routes->post('/login', 'Login::login_form');


$routes->group('/admin', static function($routes){
    $routes->group('', ['filter'=>'cifilter:auth'], static function($routes){
       
        $routes->get('home','AdminController::index', ['as'=> 'admin.home']);
        $routes->get('logout','AdminController::logoutHandler', ['as'=> 'admin.logout']);
        $routes->get('profile','AdminController::profile', ['as'=> 'admin.profile']);
        $routes->post('update-personal-details', 'AdminController::updatePersonalDetails', ['as'=> 'update-personal-details']);
        $routes->post('update-profile-picture','AdminController::updateProfilePicture', ['as' => 'update-profile-picture']);
        $routes->post('change-password', 'AdminController::changePassword', ['as'=> 'change-password']);
        $routes->get('categories','AdminController::categories', ['as'=> 'categories']);
        $routes->post('add-category','AdminController::addCategory', ['as'=> 'add-category']);
        $routes->get('get-categories','AdminController::getCategories', ['as'=> 'get-categories']);
        $routes->get('get-category','AdminController::getCategory', ['as'=> 'get-category']);
        $routes->post('update-category','AdminController::updateCategory', ['as'=> 'update-category']);
        $routes->get('delete-category','AdminController::deleteCategory', ['as'=> 'delete-category']);
        
        $routes->group('comics', static function($routes){
            $routes->get('new-comic','AdminController::addComic', ['as'=> 'new-comic']);
        });
   
    });

    $routes->group('', ['filter'=>'cifilter:guest'], static function($routes){
        
        
        $routes->get('authlogin','AuthController::loginForm', ['as'=> 'admin.login.form']);
        $routes->post('authlogin', 'AuthController::loginHandler', ['as'=> 'admin.login.handler']);
        $routes->get('forgot-password', 'AuthController::forgotForm', ['as' => 'admin.forgot.form']);
        $routes->post('send-password-reset-link', 'AuthController::sendPasswordResetLink', ['as'=> 'send_password_reset_link']);
        $routes->get('password/reset/(:any)','AuthController::resetPassword/$1', ['as'=> 'admin.reset-password']);
        $routes->post('reset-password-handler/(:any)', 'AuthController::resetPasswordHandler/$1', ['as'=> 'reset-password-handler']);
    });
        
        
    
});