<?php

namespace Config;
use App\Controllers\Crudcontroller;
use App\Controllers\PageController;
use App\Controllers\PostsController;

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
$routes->get('/', 'Crudcontroller::showLogin');

// Auth
$routes->get('/registration', 'Crudcontroller::index');    //register screen
$routes->match(['get', 'post'], 'register-user', [Crudcontroller::class, 'save']);  //save user

$routes->get('/login', 'Crudcontroller::showLogin');    //login screen
$routes->match(['get', 'post'], 'login-user', [Crudcontroller::class, 'login']);  //login user

$routes->get('/logout', 'Crudcontroller::logout');    //logout user


// logged in screens
$routes->get('/users-list', 'Crudcontroller::fetchUsers');    //display registered users

$routes->get('/edit-user/(:num)', 'Crudcontroller::showEditUser/$1');    //show edit user screen
$routes->post('/update-user', 'Crudcontroller::updateUser');    //update user details

$routes->get('/delete-screen/(:num)', 'Crudcontroller::showDeletePage/$1');    //show delete user screen
$routes->post('/delete-user', 'Crudcontroller::deleteUser');    //delete user

$routes->get('/nav-sidebar', 'PageController::sideBar');
$routes->get('/dashboard-view', 'PageController::showDashboard');
$routes->get('/success', 'PageController::showSuccess');

//posts
$routes->get('/add-post', 'PostsController::addPost');  //add post
$routes->get('/view-posts', 'PostsController::index');  //view posts
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