<?php
$db = new \PDO('mysql:dbname=example;host=localhost;charset=utf8mb4', 'mysql', 'mysql');
$auth = new \Delight\Auth\Auth($db);

$this->layout('template', ['title' => 'Page not found','auth'=>$auth]) ?>

<center>
<h1><b>Страница не найдена 404. <br> возможно она переехала и больше не доступна по этому адресу</b></h1>
</center>
