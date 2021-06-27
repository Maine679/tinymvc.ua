<?php
use \Tamtamchik\SimpleFlash\Flash;

// Create new Plates instance
$templates = new League\Plates\Engine('../application/view');



if(!empty($_POST['email']) && !empty($_POST['password'])) {

    try {

        $userId = $auth->register($_POST['email'], $_POST['password'], $_POST['email']);

        Flash::success("Вы успешно зарегистрировались в системе.");
        header('location:login');
        die();


        echo 'We have signed up a new user with the ID ' . $userId;
    } catch (\Delight\Auth\InvalidEmailException $e) {
//        die('Invalid email address');
        Flash::error('Invalid email address');
        header('location:register');
        die();
    } catch (\Delight\Auth\InvalidPasswordException $e) {
//        die('Invalid password');
        Flash::error('Invalid password');
        header('location:register');
        die();
    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
//        die('User already exists');
        Flash::error('User already exists');
        header('location:register');
        die();
    } catch (\Delight\Auth\TooManyRequestsException $e) {
//        die('Too many requests');
        Flash::error('Too many requests');
        header('location:register');
        die();
    }



}



// Render a template
echo $templates->render('register_view');
