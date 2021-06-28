<?php

ini_set('display_errors', 1);


// Start a Session
if( !session_id() ) @session_start();


require '../vendor/autoload.php';



$db = new \PDO('mysql:dbname=example;host=localhost;charset=utf8mb4', 'mysql', 'mysql');
$auth = new \Delight\Auth\Auth($db);


// use the factory to create a Faker\Generator instance
//$faker = Faker\Factory::create();
//$mysql = "INSERT INTO client (name,phone,position,email,address,social_vk,social_tg,social_inst,login) values (:name,:phone,:position,:email,:address,:social_vk,:social_tg,:social_inst,:login);";
//$insts = $db->prepare($mysql);
//$res = $insts->execute([
//    'name' => $faker->name,
//    'phone' => $faker->phoneNumber,
//    'position' => "programist",
//    'email' => $faker->email,
//    'address' => $faker->address,
//    'social_vk' => 'vk.com',
//    'social_tg' => 'tg',
//    'social_inst' => 'instagram',
//    'login' => $faker->name
//]);
//
//$res = $insts->errorCode();
//
//
//echo "test $res";
//
//die();







$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    $r->addRoute('GET', '/main', 'controller_users');
    $r->addRoute('GET', '/users[/{page:\d+}]', 'controller_users');
    $r->addRoute('GET', '/', 'controller_users');

    $r->addRoute('GET', '/user/{order:\d+}', 'controller_profile');
    $r->addRoute('GET', '/profile/{order:\d+}', 'controller_profile');

    $r->addRoute('GET', '/status/{order:\d+}', 'controller_status');

    $r->addRoute(['POST','GET'], '/media/{order:\d+}', 'controller_media');

    $r->addRoute(['POST','GET'], '/edit/{order:\d+}', 'controller_edit');

    $r->addRoute(['POST','GET'], '/security/{order:\d+}', 'controller_security');

//    {id} must be a number (\d+)
//    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
//    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
//    The /{title} suffix is optional
//    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');


    $r->addRoute('GET', '/404', 'controller_404');
    $r->addRoute(['POST', 'GET'], '/login', 'controller_login');
    $r->addRoute(['POST', 'GET'], '/register', 'controller_register');
    $r->addRoute(['POST', 'GET'], '/logout', 'controller_logout');

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        include "../application/controllers/controller_404.php";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];


        $db = new \PDO('mysql:dbname=example;host=localhost;charset=utf8mb4', 'mysql', 'mysql');
        $auth = new \Delight\Auth\Auth($db);



        include "../application/controllers/{$handler}.php";
        break;
}



