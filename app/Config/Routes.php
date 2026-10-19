<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

// Protected Routes
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');

    // Products Routes
    $routes->get('products', 'Products::index');
    $routes->get('products/new', 'Products::create');
    $routes->post('products', 'Products::store');
    $routes->get('products/image/(:segment)', 'Products::image/$1');
    $routes->get('products/(:num)/edit', 'Products::edit/$1');
    $routes->post('products/(:num)/update', 'Products::update/$1');
    $routes->post('products/(:num)/delete', 'Products::delete/$1');

    // Customers Routes
    $routes->get('customers', 'Customers::index');
    $routes->get('customers/new', 'Customers::create');
    $routes->post('customers', 'Customers::store');
    $routes->get('customers/(:num)/edit', 'Customers::edit/$1');
    $routes->post('customers/(:num)/update', 'Customers::update/$1');
    $routes->post('customers/(:num)/delete', 'Customers::delete/$1');

    // Staff / Users Routes
    $routes->get('users', 'UserController::index');
    $routes->get('users/new', 'UserController::new');
    $routes->post('users/create', 'UserController::create');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->get('users/delete/(:num)', 'UserController::delete/$1');
    $routes->post('users/delete/(:num)', 'UserController::delete/$1');

    // Sales Routes
    $routes->get('sales', 'RecordController::index');
    $routes->get('sales/new', 'RecordController::index');
    $routes->get('sales/history', 'RecordController::history');
    $routes->post('sales/store', 'RecordController::store');
});