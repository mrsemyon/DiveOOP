<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$user = QueryBuilder::read('users', ['email' => $_POST['email']]);

if (!empty($user) && password_verify($_POST['password'], $user['password'])) {
    Session::put('email', $_POST['email']);
    Session::put('role', 'user');
    Session::flash('success', 'Авторизация прошла успешно.');
    Redirect::to('/public/users');
    exit;
}

Session::flash('danger', 'Неверное имя пользователя или пароль.');
Redirect::to('/public/authorization');
exit;
