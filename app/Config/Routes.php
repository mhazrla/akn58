<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'LayoutController::index');
$routes->get('/category', 'CategoryController::index', ['filter' => 'role:admin']);
$routes->get('/category/add', 'CategoryController::add', ['filter' => 'role:admin']);
$routes->get('/category/edit/', 'CategoryController::edit/', ['filter' => 'role:admin']);
$routes->post('/category/update', 'CategoryController::update', ['filter' => 'role:admin']);
$routes->post('/category/store', 'CategoryController::store', ['filter' => 'role:admin']);
$routes->post('/category/destroy', 'CategoryController::destroy', ['filter' => 'role:admin']);

$routes->get('/product', 'ProductController::index', ['filter' => 'role:admin']);
$routes->get('/product/add', 'ProductController::add', ['filter' => 'role:admin']);
$routes->get('/product/getCategory', 'ProductController::getCategory', ['filter' => 'role:admin']);
$routes->get('/product/edit/(:num)', 'ProductController::edit/$1', ['filter' => 'role:admin']);
$routes->post('/product/store', 'ProductController::store', ['filter' => 'role:admin']);
$routes->post('/product/update', 'ProductController::update', ['filter' => 'role:admin']);
$routes->post('/product/destroy', 'ProductController::destroy', ['filter' => 'role:admin']);

$routes->get('/sales', 'SalesController::index');
$routes->get('/sales/add', 'SalesController::add');
$routes->post('/sales/data', 'SalesController::data');
$routes->get('/sales/getProduct', 'SalesController::getProduct');
$routes->get('/sales/sumTotal', 'SalesController::sumTotal');
$routes->get('/sales/viewDataProduct', 'SalesController::viewDataProduct');
$routes->get('/sales/createFaktur', 'SalesController::createFaktur');
$routes->get('/sales/edit/(:num)', 'SalesController::edit/$1');
$routes->post('/sales/store', 'SalesController::store');
$routes->post('/sales/update', 'SalesController::update');
$routes->post('/sales/destroy', 'SalesController::destroy');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
