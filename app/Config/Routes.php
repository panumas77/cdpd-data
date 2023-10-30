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

// Home
$routes->get('home', 'Home::index',['filter'=>'auth']);
$routes->get('test', 'Test::index');
$routes->get('home/test', 'Home::test');
$routes->get('home/edit/(:num)', 'Home::edit/$1');
$routes->get('not_allowed', 'Home::notAllowed');


// Patients
$routes->get('patients', 'Patients::index',['filter'=>'auth']);
$routes->match(['GET', 'POST'], 'patients/add', 'Patients::add',['filter'=>'auth']);
$routes->get('patients/edit/(:num)', 'Patients::edit/$1',['filter'=>'auth']);
$routes->post('patients/update/(:num)', 'Patients::update/$1',['filter'=>'auth']);
$routes->get('patients/delete/(:num)', 'Patients::delete/$1',['filter'=>'auth']);
$routes->get('patients/info/(:num)', 'Patients::info/$1',['filter'=>'auth']);
$routes->get('patients/profilePicture/(:num)', 'Patients::profilePicture/$1',['filter'=>'auth']);

//--- Patient/Profile 
$routes->get('patients/profile/(:num)', 'Patients::profile/$1',['filter'=>'auth']);

// Caregivers
$routes->get('caregivers', 'Caregivers::index');
$routes->match(['GET', 'POST'], 'caregivers/add', 'Caregivers::add');
$routes->get('caregivers/delete/(:num)', 'Caregivers::delete/$1');
$routes->get('caregivers/info/(:num)', 'Caregivers::info/$1');


// Saraban
$routes->get('saraban', 'Saraban::index',['filter'=>'auth']);
$routes->match(['GET', 'POST'], 'saraban/add', 'Saraban::add',['filter'=>'auth']);
$routes->post('saraban/add', 'Saraban::add',['filter'=>'auth']);
$routes->get('saraban/edit/(:num)', 'Saraban::edit/$1',['filter'=>'auth']);
$routes->post('saraban/update/(:num)', 'Saraban::update/$1',['filter'=>'auth']);
$routes->get('saraban/delete/(:num)', 'Saraban::delete/$1',['filter'=>'auth']);
$routes->get('saraban/info/(:num)', 'Saraban::info/$1',['filter'=>'auth']);
$routes->get('saraban/profilePicture/(:num)', 'Saraban::profilePicture/$1',['filter'=>'auth']);


// Users
$routes->get('users', 'Users::index',['filter'=>'auth','filter'=>'authRoot']);
$routes->match(['GET', 'POST'], 'users/create', 'Users::create',['filter'=>'auth','filter'=>'authRoot']);
$routes->get('users/info/(:num)', 'Users::info/$1',['filter'=>'auth','filter'=>'authRoot']);
$routes->get('users/delete/(:num)', 'Users::delete/$1',['filter'=>'auth','filter'=>'authRoot']);
$routes->match(['GET', 'POST'], 'users/update', 'Users::update',['filter'=>'auth','filter'=>'authRoot']);
$routes->get('users/edit/(:num)', 'Users::edit/$1',['filter'=>'auth','filter'=>'authRoot']);
$routes->post('users/update/(:num)', 'Users::update/$1',['filter'=>'auth','filter'=>'authRoot']);

$routes->get('profile', 'Users::profile',['filter'=>'auth']);
$routes->get('profile/edit/(:num)', 'Users::profileEdit/$1',['filter'=>'auth']);
$routes->post('profile/update/(:num)', 'Users::profileUpdate/$1',['filter'=>'auth']);
$routes->get('password/(:num)', 'Users::password/$1',['filter'=>'auth']);
$routes->post('password/update/(:num)', 'Users::passwordUpdate/$1',['filter'=>'auth']);

// Login 
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('auth', 'Login::auth');
$routes->get('logout', 'Login::logout');

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
