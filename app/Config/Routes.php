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
        $routes->view('example-page','example-page');
    });

    $routes->group('', [], static function($routes){
        $routes->view('example-auth','example-auth');
    });

});