<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

/*
|--------------------------------------------------------------------------
| VISTAS
|--------------------------------------------------------------------------
*/
$routes->get('login', 'AuthController::loginPage');
$routes->get('register', 'AuthController::registerPage');
$routes->get('perfil', 'UserController::perfilPage');
$routes->get('admin/generos', 'AdminController::generosPage');
$routes->get('admin/canciones', 'AdminController::cancionesPage');
$routes->get('reproductor', 'MusicController::reproductorPage');
/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/
$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {

    // Públicas
    $routes->post('login', 'AuthController::login');
    $routes->post('register', 'AuthController::register');

    // Protegidas
    $routes->group('', ['filter' => 'auth'], function($routes) {
        $routes->get('perfil', 'UserController::perfil');
        $routes->get('generos', 'GeneroController::index');
        $routes->get('generos/(:num)', 'GeneroController::show/$1');
        $routes->get('canciones', 'CancionController::index');
        $routes->get('canciones/(:num)', 'CancionController::show/$1');

        $routes->get('playlists', 'PlaylistController::index');
        $routes->get('playlists/(:num)', 'PlaylistController::show/$1');
        $routes->post('playlists/(:num)/canciones', 'PlaylistController::addSong/$1');
        $routes->delete('playlists/(:num)/canciones/(:num)', 'PlaylistController::removeSong/$1/$2');
    });


    // Solo ADMIN
    $routes->group('admin', ['filter' => 'admin'], function($routes) {
        $routes->post('generos', 'GeneroController::store');
        $routes->put('generos/(:num)', 'GeneroController::update/$1');
        $routes->delete('generos/(:num)', 'GeneroController::delete/$1');

        $routes->post('canciones', 'CancionController::store');
        $routes->put('canciones/(:num)', 'CancionController::update/$1');
        $routes->delete('canciones/(:num)', 'CancionController::delete/$1');
    });

});