<?php

use \Delight\Auth\Auth;
$db = new \PDO('mysql:dbname=example;host=localhost;charset=utf8mb4', 'mysql', 'mysql');
$auth = new \Delight\Auth\Auth($db);

use Delight\Auth\AuthError;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;
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

$order = (int)$vars['order'];
if($order <= 0)
    $order = 1;


$db->table('client')
    ->select('*')
    ->limit($order,1)
    ->orderBy('client.id')
    ->leftJoin('users','client.login_id','users.id')
    ->getAll();

//SELECT * FROM client LEFT JOIN users ON client.login_id = users.id ORDER BY client.id ASC LIMIT 3, 1


$res = $db->fetch(\PDO::FETCH_ASSOC);


if(!empty($_POST['email']) || !empty($_POST['password']) || !empty($_POST['confirm_password'])) {
    $userEmail = $auth->getEmail();


    if ($_POST['email'] !== $userEmail) {
        var_dump($userEmail);
        try {
            $auth->changeEmail($_POST['email'], function ($selector, $token) {
                Flash::message('Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email to the *new* address)');
            });
            Flash::message('Емейл для входа изменён.');


        } catch (AuthError | NotLoggedInException $e) {
            Flash::error('Пользователь не авторизован');
        } catch (EmailNotVerifiedException $e) {
            Flash::error('Емейл не подтверждён');
        } catch (InvalidEmailException $e) {
            Flash::error('Некорректный емейл');
        } catch (TooManyRequestsException $e) {
            Flash::error('Слишком много переходов');
        } catch (UserAlreadyExistsException $e) {
            Flash::error('Пользователь с таким имейлом уже есть в базе');
        }

    }


    if($_POST['passowrd'] == $_POST['confirm_password'] && $_POST['passowrd'] !== '' && !empty($_POST['old_password'])) {

        try {
            $auth->changePassword($_POST['old_password'], $_POST['password']);
            Flash::message('Пароль для входа изменён');
        } catch (AuthError $e) {
        } catch (InvalidPasswordException $e) {
        } catch (NotLoggedInException $e) {
        } catch (TooManyRequestsException $e) {
        }

    }
}






// Create new Plates instance
$templates = new League\Plates\Engine('../application/view');

// Render a template
echo $templates->render('security_view', ['res'=>$res,'auth'=>$auth]);
