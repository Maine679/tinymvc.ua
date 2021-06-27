<?php

$db = new \PDO('mysql:dbname=example;host=localhost;charset=utf8mb4', 'mysql', 'mysql');
$auth = new \Delight\Auth\Auth($db);

use \Tamtamchik\SimpleFlash\Flash;

// import the Intervention Image Manager Class
use \Intervention\Image\ImageManager;
use \Intervention\Image\Image;

if(!$auth->isLoggedIn()) {
    Flash::error('Для просмотра авторизуйтесь на сайте.');
    header('location:login');
    die();
}

$config = [
    'host'		=> 'localhost',
    'driver'	=> 'mysql',
    'database'	=> 'example',
    'username'	=> 'mysql',
    'password'	=> 'mysql',
    'charset'	=> 'utf8',
    'collation'	=> 'utf8_general_ci',
    'prefix'	 => ''
];

$db = new \Buki\Pdox($config);

$order = (int)$order;
if($order < 0)
    $order = 0;



$db->table('client')
    ->select('*')
    ->limit($order,1)
    ->orderBy('id')
    ->getAll();

$res = $db->fetch(\PDO::FETCH_ASSOC);


$image = $_FILES['image']['tmp_name'];

//var_dump($_FILES); die();

if(!empty($image)) {
//    var_dump($_FILES); die();

    $img = new Intervention\Image\Image();

//    composer require spatie/laravel-medialibrary
    $img_1 = $img->make($image);
    var_dump($img_1);
}




// Create new Plates instance
$templates = new League\Plates\Engine('../application/view');

// Render a template
echo $templates->render('media_view', ['order'=>(int)$vars['order']]);
