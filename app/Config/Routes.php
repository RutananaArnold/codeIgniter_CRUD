<?php

namespace Config;
use App\Controllers\CrudController;
use App\Controllers\CrudAPI;
use App\Filters;

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
$routes->get('/', 'CrudController::showLogin');

// Auth
$routes->get('/registration', 'CrudController::index');    //register screen
$routes->match(['get', 'post'], '/register-user', [CrudController::class, 'save']);  //save user

$routes->get('/login', 'CrudController::showLogin');    //login screen
$routes->match(['get', 'post'], '/login-user', [CrudController::class, 'login']);  //login user

$routes->get('/logout', 'CrudController::logout');    //logout user


// logged in screens
$routes->get('/users-list', 'CrudController::fetchUsers', ['filter' => 'authMiddleware']);    //display registered users

$routes->get('/edit-user/(:num)', 'CrudController::showEditUser/$1', ['filter' => 'authMiddleware']);    //show edit user screen
$routes->post('/update-user', 'CrudController::updateUser', ['filter' => 'authMiddleware']);    //update user details

$routes->get('/delete-screen/(:num)', 'CrudController::showDeletePage/$1', ['filter' => 'authMiddleware']);    //show delete user screen
$routes->post('/delete-user', 'CrudController::deleteUser', ['filter' => 'authMiddleware']);    //delete user

$routes->get('/nav-sidebar', 'PageController::sideBar', ['filter' => 'authMiddleware']);
$routes->get('/dashboard-view', 'PageController::showDashboard', ['filter' => 'authMiddleware']);
$routes->get('/success', 'PageController::showSuccess', ['filter' => 'authMiddleware']);

//posts
$routes->get('/add-post', 'PostsController::addPost', ['filter' => 'authMiddleware']);  //add post screen
$routes->post('/upload-post', 'PostsController::uploadPost', ['filter' => 'authMiddleware']);  //upload post

$routes->get('/view-posts', 'PostsController::fetchPosts', ['filter' => 'authMiddleware']);  //view posts page



//API'S endpoints
$routes->group("api", function () {
    $routes = Services::routes();
    $routes->post('user-registration', [CrudAPI::class, 'register']);
    $routes->post('user-login', 'CrudAPI::login');
    $routes->get('users-list', 'CrudAPI::index', ['filter' => 'apiAuthFilter']);
});

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