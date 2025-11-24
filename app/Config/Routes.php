<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// Protected Routes
$routes->group('admin', ['filter' => 'authGuard'], function($routes){
    $routes->get('dashboard', 'Dashboard::admin');

    // NEW ROUTES FOR USER MANAGEMENT
    $routes->get('users', 'Dashboard::users'); // View List
    $routes->get('deleteUser/(:num)', 'Dashboard::deleteUser/$1'); // Delete Action

});

$routes->group('faculty', ['filter' => 'authGuard'], function($routes){
    $routes->get('dashboard', 'Dashboard::faculty');
});

$routes->post('/file/upload', 'FileHandler::upload', ['filter' => 'authGuard']);
$routes->get('/file/download/(:num)', 'FileHandler::download/$1', ['filter' => 'authGuard']);
$routes->get('/file/delete/(:num)', 'FileHandler::delete/$1', ['filter' => 'authGuard']);

$routes->get('/register', 'Auth::register');
$routes->post('/auth/store', 'Auth::store');
