<?php
// Create new Plates instance
$templates = new League\Plates\Engine('../application/view');
use \Tamtamchik\SimpleFlash\Flash;


if(!empty($_POST['email']) && !empty($_POST['password'])) {
    try {

        if ($_POST['remember'] == 1) {
            // keep logged in for one year
            $rememberDuration = (int) (60 * 60 * 24 * 365.25);
        }
        else {
            // do not keep logged in after session ends
            $rememberDuration = null;
        }


        $auth->login($_POST['email'], $_POST['password'],$rememberDuration);
        Flash::success('Вы авторизованы.');
        header('location:users');
        die();

    } catch (\Delight\Auth\InvalidEmailException $e) {
        Flash::error('Wrong email address');
        header('location:login');
        die();
    } catch (\Delight\Auth\InvalidPasswordException $e) {
        Flash::error('Wrong password');
        header('location:login');
        die();
    } catch (\Delight\Auth\EmailNotVerifiedException $e) {
        Flash::error('Email not verified');
        header('location:login');
        die();
    } catch (\Delight\Auth\TooManyRequestsException $e) {
        Flash::error('Too many requests');
        header('location:login');
        die();
    }

}



// Render a template
echo $templates->render('login_view');