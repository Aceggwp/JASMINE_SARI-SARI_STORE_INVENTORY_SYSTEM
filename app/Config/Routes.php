<?php

namespace Config;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Auth Routes (public)
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/attempt', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');

// Protected Routes (with auth filter)
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('/dashboard', 'Dashboard::index');
    
    // Categories
    $routes->resource('categories', ['controller' => 'Categories']);
    
    // Products
    $routes->resource('products', ['controller' => 'Products']);
    $routes->post('products/update-stock/(:num)', 'Products::updateStock/$1');
    
    // Sales
    $routes->get('sales', 'Sales::index');
    $routes->get('sales/create', 'Sales::create');
    $routes->post('sales/store', 'Sales::store');
    $routes->get('sales/(:num)', 'Sales::show/$1');
    $routes->get('sales/invoice/(:num)', 'Sales::invoice/$1');
    $routes->delete('sales/(:num)', 'Sales::delete/$1');
    
    // Stock Management
    $routes->get('stock', 'Stock::index');
    $routes->get('stock/adjust', 'Stock::adjust');
    $routes->post('stock/adjust-store', 'Stock::adjustStore');
    $routes->get('stock/logs', 'Stock::logs');
    
    // Logs
    $routes->get('logs', 'Logs::index');
    
    // Users (admin only)
    $routes->group('users', ['filter' => 'admin'], function($routes) {
        $routes->get('/', 'Users::index');
        $routes->get('create', 'Users::create');
        $routes->post('store', 'Users::store');
        $routes->get('edit/(:num)', 'Users::edit/$1');
        $routes->post('update/(:num)', 'Users::update/$1');
        $routes->delete('delete/(:num)', 'Users::delete/$1');
    });
    
    // AJAX endpoints
    $routes->get('api/get-product/(:any)', 'Api::getProduct/$1');
    $routes->get('api/get-products', 'Api::getProducts');
});

