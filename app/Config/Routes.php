<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/register', 'Register::index');

$routes->get('/login', 'Login::index');

$routes->post('/registro-de-usuarios', 'Register::guardar');

$routes->get('/success', 'Register::success');