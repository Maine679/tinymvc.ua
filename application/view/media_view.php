<?php


//var_dump($_FILES); die();





//var_dump($_POST);
//echo "<br>";
//var_dump($_GET);
//echo "<br>";
//var_dump($GLOBALS);
//echo "<br>";
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

<!--                            <div class="form-group">-->
<!--                                <label class="form-label" for="example-fileinput">Выберите аватар</label>-->
<!--                                <input type="file" name="image" id="example-fileinput" class="form-control-file">-->
<!--                            </div>-->
<!---->
<!--                            <form method="POST" enctype="multipart/form-data">-->
<!--                                <input type="file" name="image" value=""/>-->
<!--                                <input type="submit" value="Загрузить"/>-->
<!--                            </form>-->


                            <form method="post" enctype="multipart/form-data">
                                Выберите файл: <input type="file" name="image" size="10" /><br /><br />
                                <input type="submit" value="Загрузить" />
                            </form>


<!--                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">-->
<!--                                <button class="btn btn-warning">Загрузить</button>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>
