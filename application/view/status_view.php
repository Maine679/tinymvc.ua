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


$status = $_GET['user_status'];



if($status !== NULL) {
    switch ($status) {
        case 1: $value = 'online';break;
        case 2: $value = 'offline';break;
    }

    $db->table('client')
        ->where('id', '=', $res->id)
        ->update(['status' => $value]);

}

$this->layout('template', ['title' => 'Статус','auth'=>$auth]) ?>


<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-sun'></i> Установить статус<b> <?=$res->name ?></b>
        </h1>

    </div>
    <form action="">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Установка текущего статуса</h2>
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- status -->
                                    <div class="form-group">
                                        <label class="form-label" for="example-select">Выберите статус</label>
                                        <select class="form-control" name="user_status" id="example-select">
                                            <option value="1" <?=$res->status=='online' ? "selected":"" ?>>Онлайн</option>
                                            <option value="2" <?=$res->status=='offline' ? "selected":"" ?>>Отошел</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Set Status</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</main>