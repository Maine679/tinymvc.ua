<?php

$db = new \PDO('mysql:dbname=example;host=localhost;charset=utf8mb4', 'mysql', 'mysql');
$auth = new \Delight\Auth\Auth($db);

$this->layout('template', ['title' => 'Пользователи','auth'=>$auth]);


?>
<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-image'></i> Загрузить аватар <br><b><?=$res->name; ?></b>
        </h1>

    </div>
    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Текущий аватар</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <img src="<?=$res->img; ?>" alt="" class="img-responsive" width="200">
                            </div>

                            <form method="post" enctype="multipart/form-data">
                                Выберите файл: <input type="file" name="image" size="10" /><br /><br />
                                <input type="submit" value="Загрузить" />
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>
