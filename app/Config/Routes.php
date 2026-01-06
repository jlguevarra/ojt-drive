<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. DEFAULT ROUTE
$routes->get('/', 'Auth::index');

// 2. AUTHENTICATION ROUTES
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/store', 'Auth::store');

// 3. ADMIN ROUTES
$routes->group('admin', ['filter' => 'authGuard'], function($routes){
    $routes->get('dashboard', 'Dashboard::admin');
    $routes->get('users', 'Dashboard::users');
    $routes->get('deleteUser/(:num)', 'Dashboard::deleteUser/$1');
    $routes->post('createUser', 'Dashboard::createUser');
    $routes->post('updateUser', 'Dashboard::updateUser');
    $routes->get('logs', 'Dashboard::logs');
    $routes->get('departments', 'Departments::index'); 

    // ARCHIVE ROUTES
    $routes->get('archive', 'Archive::index');
    $routes->get('archive/restore/(:segment)/(:num)', 'Archive::restore/$1/$2');
    $routes->get('archive/delete/(:segment)/(:num)', 'Archive::delete_permanent/$1/$2');
});

// 4. DEPARTMENT ACTIONS
$routes->group('departments', ['filter' => 'authGuard'], function($routes){
    $routes->post('create', 'Departments::create');
    $routes->post('update', 'Departments::update');
    $routes->get('delete/(:num)', 'Departments::delete/$1');
});

// 5. FACULTY ROUTES
$routes->group('faculty', ['filter' => 'authGuard'], function($routes){
    $routes->get('dashboard', 'Dashboard::faculty');
});

// 6. FILE & FOLDER HANDLING
$routes->post('/file/upload', 'FileHandler::upload', ['filter' => 'authGuard']);
// [NEW] Upload Folder Route
$routes->post('/file/upload_folder', 'FileHandler::upload_folder', ['filter' => 'authGuard']);

$routes->get('/file/download/(:num)', 'FileHandler::download/$1', ['filter' => 'authGuard']);
$routes->get('/file/delete/(:num)', 'FileHandler::delete/$1', ['filter' => 'authGuard']); // Moves to Archive
$routes->get('/file/preview/(:num)', 'FileHandler::preview/$1', ['filter' => 'authGuard']);

$routes->post('/folder/create', 'FileHandler::create_folder', ['filter' => 'authGuard']);
$routes->get('/folder/delete/(:num)', 'FileHandler::delete_folder/$1', ['filter' => 'authGuard']); // Moves to Archive


// 7. SETTINGS
$routes->group('settings', ['filter' => 'authGuard'], function($routes){
    $routes->get('/', 'Settings::index');
    $routes->post('update', 'Settings::update');
});