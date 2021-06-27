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

$order = (int)$vars['order'];
if($order < 0)
    $order = 0;



$db->table('client')
    ->select('*')
    ->limit($order,1)
    ->orderBy('id')
    ->getAll();



$res = $db->fetch(\PDO::FETCH_ASSOC);

$tmpName = $_FILES['image']['tmp_name'];

if(!empty($tmpName)) {
    $error = $_FILES['image']['error'];

    $fi = finfo_open(FILEINFO_MIME_TYPE);
    $mime = (string) finfo_file($fi, $tmpName);

    $image = getimagesize($tmpName);
    $format = image_type_to_extension($image[2]);

    $newFileName = 'img_' . md5(microtime()) . $format;

    move_uploaded_file($tmpName, __DIR__ . '\..\..\img\demo\avatars\\' . $newFileName);

    $db->table('client')
        ->where('id',$res->id)
        ->update(['img'=>'../../img/demo/avatars/' . $newFileName]);

}




// Create new Plates instance
$templates = new League\Plates\Engine('../application/view');

// Render a template
echo $templates->render('media_view', ['res'=>$res]);
