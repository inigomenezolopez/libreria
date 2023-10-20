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
