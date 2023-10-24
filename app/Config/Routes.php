<?php

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


$routes->group('admin', static function($routes){
    $routes->group('', [], static function($routes){
       
        $routes->get('home','AdminController::index', ['as'=> 'admin.home']);
    });

    $routes->group('', [], static function($routes){
        
        
        $routes->get('authlogin','AuthController::loginForm', ['as'=> 'admin.login.form']);
        $routes->post('authlogin', 'AuthController::loginHandler');
        
    });
        
        
    
});