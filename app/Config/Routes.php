<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// ==================== AUTHENTICATION (Public) ====================
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::auth');
$routes->post('/auth', 'Auth::auth');
$routes->post('/auth/attempt', 'Auth::auth');  // <-- ADD THIS LINE
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::doRegister');
$routes->post('/auth/register', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');

// ==================== PROTECTED ROUTES (Logged in users) ====================
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    
    // Logs (accessible by admin/staff)
    $routes->get('/logs', 'Logs::index');

    // Dashboard
    $routes->get('/dashboard', 'Dashboard::index');
    
    // Sales (POS, Cart, History, Receipt)
    $routes->get('/sales/create', 'Sales::create');   // Show sale creation form
    $routes->get('/sales', 'Sales::index');              // <-- ADD THIS (list of sales)
    $routes->get('/sales/pos', 'Sales::pos');
    $routes->post('/sales/addToCart', 'Sales::addToCart');
    $routes->get('/sales/getCart', 'Sales::getCart');
    $routes->post('/sales/updateCart', 'Sales::updateCart');
    $routes->get('/sales/removeFromCart/(:num)', 'Sales::removeFromCart/$1');
    $routes->post('/sales/checkout', 'Sales::checkout');
    $routes->get('/sales/receipt/(:num)', 'Sales::receipt/$1');
    $routes->get('/sales/history', 'Sales::history');
    
    // Reports (accessible by both admin and staff)
    $routes->get('/reports', 'Reports::index');
    
    // ========== ADMIN ONLY ROUTES ==========
    $routes->group('', ['filter' => 'auth:admin'], function($routes) {
        
        // Product Management (GET = view, POST = create/update/delete)
        $routes->get('/products', 'Products::index');
        $routes->get('/products/create', 'Products::create');
        $routes->post('/products/store', 'Products::store');
        $routes->get('/products/edit/(:num)', 'Products::edit/$1');
        $routes->post('/products/update/(:num)', 'Products::update/$1');
        $routes->get('/products/delete/(:num)', 'Products::delete/$1');
        
        // Category Management
        $routes->get('/categories', 'Categories::index');
        $routes->post('/categories/store', 'Categories::store');
        $routes->post('/categories/update/(:num)', 'Categories::update/$1');
        $routes->get('/categories/delete/(:num)', 'Categories::delete/$1');
        
        // Stock Management
        $routes->get('/stock', 'Stock::index');
        $routes->post('/stock/add', 'Stock::addStock');
        
        // User Management
        $routes->get('/users', 'Users::index');
        $routes->get('/users/create', 'Users::create');
        $routes->post('/users/store', 'Users::store');
        $routes->get('/users/edit/(:num)', 'Users::edit/$1');        // <-- ADD THIS
        $routes->post('/users/update/(:num)', 'Users::update/$1');
        $routes->get('/users/delete/(:num)', 'Users::delete/$1');
    });
});