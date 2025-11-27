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

// 3. ADMIN ROUTES (Prefix: /admin/...)
$routes->group('admin', ['filter' => 'authGuard'], function($routes){
    $routes->get('dashboard', 'Dashboard::admin');
    $routes->get('users', 'Dashboard::users');
    $routes->get('deleteUser/(:num)', 'Dashboard::deleteUser/$1');
    $routes->post('createUser', 'Dashboard::createUser');
    $routes->post('updateUser', 'Dashboard::updateUser');

    // THIS shows the page at /admin/departments (Matches your sidebar)
    $routes->get('departments', 'Departments::index'); 
});

// 4. DEPARTMENT ACTIONS (Prefix: /departments/...)
// These are OUTSIDE 'admin' group so they match your form action: base_url('departments/create')
$routes->group('departments', ['filter' => 'authGuard'], function($routes){
    $routes->post('create', 'Departments::create');
    $routes->post('update', 'Departments::update');
    $routes->get('delete/(:num)', 'Departments::delete/$1');
});

// 5. FACULTY ROUTES
$routes->group('faculty', ['filter' => 'authGuard'], function($routes){
    $routes->get('dashboard', 'Dashboard::faculty');
});

// 6. FILE HANDLING
$routes->post('/file/upload', 'FileHandler::upload', ['filter' => 'authGuard']);
$routes->get('/file/download/(:num)', 'FileHandler::download/$1', ['filter' => 'authGuard']);
$routes->get('/file/delete/(:num)', 'FileHandler::delete/$1', ['filter' => 'authGuard']);

// 7. SETTINGS
$routes->group('settings', ['filter' => 'authGuard'], function($routes){
    $routes->get('/', 'Settings::index');
    $routes->post('update', 'Settings::update');
});