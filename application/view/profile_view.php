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
if($order <= 0)
    $order = 1;


    $db->table('client')
    ->select('*')
    ->limit($order,1)
    ->orderBy('id')
    ->getAll();

    $res = $db->fetch(\PDO::FETCH_ASSOC);


$this->layout('template', ['title' => 'Профиль','auth'=>$auth]) ?>





<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
                <i class='subheader-icon fal fa-user'></i> <?=$res->name; ?>
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xl-6 m-auto">
            <!-- profile summary -->
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">
                    <div class="col-12">
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">
                            <?
                            switch($res->status) {
                                case 'online': $status = "success";break;
                                case 'offline': $status = "warning";break;
                                default: $status = "success";break;
                            }
                            ?>
                            <span class="status status-<?echo $status;?> mr-3">
                            <img src="../../img/demo/avatars/avatar-admin-lg.png" class="rounded-circle shadow-2 img-thumbnail" alt="">
                            </span>

                            <h5 class="mb-0 fw-700 text-center mt-3">
                                <?=$res->name; ?>
                                <small class="text-muted mb-0"><?=$res->address; ?></small>
                            </h5>
                            <div class="mt-4 text-center demo">
                                <a href="javascript:void(0);" class="fs-xl" style="color:#C13584">
                                    <i class="fab fa-instagram"><?=$res->social_inst; ?></i>
                                </a>
                                <a href="javascript:void(0);" class="fs-xl" style="color:#4680C2">
                                    <i class="fab fa-vk"><?=$res->social_vk; ?></i>
                                </a>
                                <a href="javascript:void(0);" class="fs-xl" style="color:#0088cc">
                                    <i class="fab fa-telegram"><?=$res->social_tg; ?></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 text-center">
                            <a href="tel:<?=$res->phone; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mobile-alt text-muted mr-2"></i><?=$res->phone; ?></a>
                            <a href="mailto:<?=$res->email; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mouse-pointer text-muted mr-2"></i><?=$res->email; ?></a>
                            <address class="fs-sm fw-400 mt-4 text-muted">
                                <i class="fas fa-map-pin mr-2"></i><?=$res->address; ?>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
