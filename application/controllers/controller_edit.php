<?php

$db = new \PDO('mysql:dbname=example;host=localhost;charset=utf8mb4', 'mysql', 'mysql');
$auth = new \Delight\Auth\Auth($db);

use \Tamtamchik\SimpleFlash\Flash;

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


if(!empty($_POST["name"]) || !empty($_POST["position"]) || !empty($_POST["phone"]) || !empty($_POST["address"])) {

    $db = new \Buki\Pdox($config);

    $order = (int)$vars['order'];
    if($order <= 0)
        $order = 1;


    $db->table('client')
        ->select('*')
        ->limit($order,1)
        ->orderBy('id')
        ->getAll();

    $res = $db->fetch(\PDO::FETCH_ASSOC);

    $data = [];
    if($res->name !== $_POST['name'])
        $data[] = ['name'=>$_POST['name']];
    if($res->position !== $_POST['position'])
        $data[] = ['position'=>$_POST['position']];
    if($res->phone !== $_POST['phone'])
        $data[] = ['phone'=>$_POST['phone']];
    if($res->address !== $_POST['address'])
        $data[] = ['address'=>$_POST['address']];


    $db->table('client')
        ->where('id',(string)$res->id)
        ->update($data[0]);


}

// Create new Plates instance
$templates = new League\Plates\Engine('../application/view');

// Render a template
echo $templates->render('edit_view', ['order'=>(int)$vars['order']]);
