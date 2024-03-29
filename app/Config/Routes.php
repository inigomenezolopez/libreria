<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'FrontPage::paginaPrincipal', ['as' => 'inicio']);

$routes->get('/todos-los-comics', 'FrontPage::todosComics', ['as' => 'todos-los-comics']);
$routes->get('/search-comics', 'FrontPage::searchComics', ['as' => 'search-comics']);
$routes->get('/comics/(:num)', 'FrontPage::comicDetails/$1');

$routes->get('novedades', 'FrontPage::latestComics', ['as' => 'latestComics']);

$routes->get('perfil', 'FrontPage::perfil', ['as' => 'perfil']);
$routes->post('actualizar_perfil', 'FrontPage::actualizar_perfil', ['as' => 'actualizar_perfil']);
$routes->get('logout', 'FrontPage::logout', ['as' => 'logout']);

$routes->get('cart', 'CartController::view', ['as' => 'carrito']);
$routes->get('cart/add/(:num)', 'CartController::add/$1');
$routes->get('cart/remove/(:num)', 'CartController::remove/$1');
$routes->get('/checkout', 'CartController::checkout');
$routes->post('/pay', 'CartController::pay', ['as' => 'pay']);
$routes->get('/payment-confirmation', 'CartController::paymentConfirmation');



$routes->get('/register', 'Register::index', ['as' => 'register']);
$routes->post('/register', 'Register::guardar');


$routes->get('/login', 'Login::index', ['as' => 'login']);
$routes->post('/login', 'Login::login_form');



$routes->get('forgot-password', 'AuthController::forgotForm', ['as' => 'admin.forgot.form']);
        $routes->post('send-password-reset-link', 'AuthController::sendPasswordResetLink', ['as' => 'send_password_reset_link']);
        $routes->get('password/reset/(:any)', 'AuthController::resetPassword/$1', ['as' => 'admin.reset-password']);
        $routes->post('reset-password-handler/(:any)', 'AuthController::resetPasswordHandler/$1', ['as' => 'reset-password-handler']);




$routes->group('/admin', static function ($routes) {
    $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {

        $routes->get('home', 'AdminController::index', ['as' => 'admin.home']);
        $routes->get('logout', 'AdminController::logoutHandler', ['as' => 'admin.logout']);
        $routes->get('profile', 'AdminController::profile', ['as' => 'admin.profile']);
        $routes->post('update-personal-details', 'AdminController::updatePersonalDetails', ['as' => 'update-personal-details']);
        $routes->post('update-profile-picture', 'AdminController::updateProfilePicture', ['as' => 'update-profile-picture']);
        $routes->post('change-password', 'AdminController::changePassword', ['as' => 'change-password']);
        $routes->get('categories', 'AdminController::categories', ['as' => 'categories']);
        $routes->post('add-category', 'AdminController::addCategory', ['as' => 'add-category']);
        $routes->get('get-categories', 'AdminController::getCategories', ['as' => 'get-categories']);
        $routes->get('get-category', 'AdminController::getCategory', ['as' => 'get-category']);
        $routes->post('update-category', 'AdminController::updateCategory', ['as' => 'update-category']);
        $routes->get('delete-category', 'AdminController::deleteCategory', ['as' => 'delete-category']);


        $routes->get('trans-info', 'AdminController::transInfo', ['as' => 'trans-info']);
        $routes->get('get-trans-info', 'AdminController::getTransInfo', ['as' => 'get-trans-info']);
        $routes->get('user-info', 'AdminController::userInfo', ['as' => 'user-info']);
        $routes->get('get-user-info', 'AdminController::getUserInfo', ['as' => 'get-user-info']);

        $routes->group('comics', static function ($routes) {
            $routes->get('new-comic', 'AdminController::addComic', ['as' => 'new-comic']);
            $routes->post('create-comic', 'AdminController::createComic', ['as' => 'create-comic']);
            $routes->get('/', 'AdminController::allComics', ['as' => 'all-comics']);
            $routes->get('get-comics', 'AdminController::getComics', ['as' => 'get-comics']);
            $routes->get('edit-comic/(:any)', 'AdminController::editComic/$1', ['as' => 'edit-comic']);
            $routes->post('update-comic', 'AdminController::updateComic', ['as' => 'update-comic']);
            $routes->get('delete-comic', 'AdminController::deleteComic', ['as' => 'delete-comic']);
        });
    });

    $routes->group('', ['filter' => 'cifilter:guest'], static function ($routes) {


        $routes->get('authlogin', 'AuthController::loginForm', ['as' => 'admin.login.form']);
        $routes->post('authlogin', 'AuthController::loginHandler', ['as' => 'admin.login.handler']);
        
    });
});
