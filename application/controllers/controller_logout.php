<?php

// Create new Plates instance
$templates = new League\Plates\Engine('../application/view');

use \Tamtamchik\SimpleFlash\Flash;


if($auth->isLoggedIn()) {
    $auth->logOut();
    Flash::success('Вы вышли из аккаунта.');
}

// Render a template
echo $templates->render('login_view');