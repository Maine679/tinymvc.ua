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
use Kilte\Pagination\Pagination;


$db = new \Buki\Pdox($config);

$records = $db->table('client')
    ->select('COUNT(*)')
    ->getAll();

$totalItems = (int)$records[0]->{"COUNT(*)"};

$currentPage = (int)$page["page"];
$itemsPerPage = 1;

if($currentPage <= 0)
    $currentPage = 1;


$order = $itemsPerPage * $currentPage-1;

//var_dump($order);

$records = $db->table('client')
    ->select('*')
    ->limit($order,$itemsPerPage)
    ->orderBy('id')
    ->getAll();

use JasonGrimes\Paginator;

$urlPattern = '/users/(:num)';

$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);



$this->layout('template', ['title' => 'Пользователи','auth'=>$auth]) ?>



<main id="js-page-content" role="main" class="page-content mt-3">

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-users'></i> Список пользователей
        </h1>
    </div>

    <? if($auth->getRoles() ==  \Delight\Auth\Role::ADMIN ): ?>
        <div class="row">
            <div class="col-xl-12">
                <a class="btn btn-success" href="/create_user">Добавить</a>

                <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                    <input type="text" id="js-filter-contacts" name="filter-contacts" class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пользователя">
                    <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                        <label class="btn btn-default active">
                            <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                        </label>
                        <label class="btn btn-default">
                            <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    <? endif; ?>




    <? foreach ($records as $item) : ?>
        <div class="row" id="js-contacts">
            <div class="col-xl-4">
                <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?=$item->name; ?>">
                    <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                        <div class="d-flex flex-row align-items-center">
                                    <?
                                        switch($item->status) {
                                            case 'online': $status = "success";break;
                                            case 'offline': $status = "warning";break;
                                            default: $status = "success";break;
                                        }
                                    ?>
                                    <span class="status status-<?echo $status;?> mr-3">
                                        <span class="rounded-circle profile-image d-block " style="background-image:url('<?=$item->img; ?>'); background-size: 550px;"></span>
                                    </span>
                            <div class="info-card-text flex-1">
                                <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                    <?=$item->name; ?>
                                    <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                    <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                </a>



                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/profile/<?=$order;?>">
                                            <i class="fa fa-edit"></i>
                                            Просмотреть</a>
                                        <a class="dropdown-item" href="/status/<?=$order;?>">
                                            <i class="fa fa-edit"></i>
                                            Изменить статус</a>
                                        <a class="dropdown-item" href="/edit/<?=$order;?>">
                                            <i class="fa fa-edit"></i>
                                            Изменить</a>
                                        <a class="dropdown-item" href="/media/<?=$order;?>">
                                            <i class="fa fa-edit"></i>
                                            Изменить аватар</a>
                                <? if($auth->getRoles() ==  \Delight\Auth\Role::ADMIN ): ?>
                                        <a class="dropdown-item" href="/edit">
                                            <i class="fa fa-edit"></i>
                                            Редактировать</a>
                                        <a class="dropdown-item" href="/security">
                                            <i class="fa fa-lock"></i>
                                            Безопасность</a>
                                        <a class="dropdown-item" href="/status">
                                            <i class="fa fa-sun"></i>
                                            Установить статус</a>
                                        <a class="dropdown-item" href="/media">
                                            <i class="fa fa-camera"></i>
                                            Загрузить аватар
                                        </a>
                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close"></i>
                                            Удалить
                                        </a>
                                <? endif; ?>
                                    </div>




                                <span class="text-truncate text-truncate-xl"><?=$item->position; ?></span>
                            </div>
                            <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                <span class="collapsed-hidden">+</span>
                                <span class="collapsed-reveal">-</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 collapse show">
                        <div class="p-3">
                            <a href="tel:<?=$item->number; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mobile-alt text-muted mr-2"></i><?=$item->number; ?></a>
                            <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?=$item->email; ?></a>
                            <address class="fs-sm fw-400 mt-4 text-muted">
                                <i class="fas fa-map-pin mr-2"></i><?=$item->address; ?></address>
                            <div class="d-flex flex-row">
                                <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">
                                    <i class="fab fa-vk"><?=$item->social_vk; ?></i>
                                </a>
                                <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">
                                    <i class="fab fa-telegram"><?=$item->social_tg; ?></i>
                                </a>
                                <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">
                                    <i class="fab fa-instagram"><?=$item->social_inst; ?></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? endforeach; ?>
    <nav aria-label="">
    <?=$paginator; ?>
    </nav>
</main>
