<?php

/**
 * Front controller
 *
 * PHP version 5.4
 */

/**
 * Composer
 */
require '../../vendor/autoload.php';


/**
 * Configurations
 */


$config = new \App\Config();
$config->load();

/**
 * Twig
 */
Twig_Autoloader::register();


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


//$whoops = new \Whoops\Run;
//$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
//$whoops->register();

/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('ping', ['controller' => 'Home', 'action' => 'ping']);

$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);

// SIGNUP
$router->add('signup', ['controller' => 'Signup', 'action' => 'index']);
$router->add('signup/create', ['controller' => 'Signup', 'action' => 'create']);
$router->add('signup/success', ['controller' => 'Signup', 'action' => 'success']);

// LOGIN
$router->add('login', ['controller' => 'Login', 'action' => 'index']);
$router->add('login/create', ['controller' => 'Login', 'action' => 'create']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);

// PROFILE
$router->add('profile/show', ['controller' => 'Profile', 'action' => 'show']);
$router->add('profile/edit', ['controller' => 'Profile', 'action' => 'edit']);
$router->add('profile/save', ['controller' => 'Profile', 'action' => 'save']);


// COMPANIES
$router->add('companies', ['controller' => 'Companies', 'action' => 'index']);
$router->add('companies/show/{id:\d+}', ['controller' => 'Companies', 'action' => 'show']);

$router->add('users/index', ['controller' => 'Users', 'action' => 'index']);

$router->add('admin/users/index', ['controller' => 'Users', 'action' => 'index', 'namespace' => 'Admin']);

//$router->add('{controller}/{action}');
//$router->add('{controller}/{id:\d+}/{action}');
//$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
    
$router->dispatch($_SERVER['QUERY_STRING']);

