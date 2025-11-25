<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. DEFAULT ROUTE (This fixes your issue!)
// When user visits localhost:8080, go to Login immediately.
$routes->get('/', 'Auth::index');

// 2. AUTHENTICATION ROUTES
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/store', 'Auth::store');

// 3. ADMIN & CHAIR ROUTES (Protected by 'authGuard')
$routes->group('admin', ['filter' => 'authGuard'], function($routes){
    $routes->get('dashboard', 'Dashboard::admin');
    $routes->get('users', 'Dashboard::users');        // Manage Users View
    $routes->get('deleteUser/(:num)', 'Dashboard::deleteUser/$1'); // Delete User Action
    $routes->post('createUser', 'Dashboard::createUser');
    $routes->post('updateUser', 'Dashboard::updateUser');
});

// 4. FACULTY ROUTES (Protected by 'authGuard')
$routes->group('faculty', ['filter' => 'authGuard'], function($routes){
    $routes->get('dashboard', 'Dashboard::faculty');
});

// 5. FILE HANDLING ROUTES
$routes->post('/file/upload', 'FileHandler::upload', ['filter' => 'authGuard']);
$routes->get('/file/download/(:num)', 'FileHandler::download/$1', ['filter' => 'authGuard']);
$routes->get('/file/delete/(:num)', 'FileHandler::delete/$1', ['filter' => 'authGuard']);

// 6. SETTINGS ROUTES
$routes->group('settings', ['filter' => 'authGuard'], function($routes){
    $routes->get('/', 'Settings::index');
    $routes->post('update', 'Settings::update');
});