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
        $routes->get('logout','AdminController::logoutHandler');
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