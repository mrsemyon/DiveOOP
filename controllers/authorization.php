<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (!Token::check(Input::get('token'))) {
    Session::flash('danger', 'Что-то пошло не так.');
    Redirect::to('/public/authorization');
    exit;
}

$user = QueryBuilder::getInstance()->read('users', ['email' => Input::get('email')]);

if (!empty($user) && password_verify(Input::get('password'), $user['password'])) {
    Session::put('email', Input::get('email'));
    Session::put('role', $user['role']);
    Session::flash('success', 'Авторизация прошла успешно.');
    Redirect::to('/public/users');
    exit;
}

Session::flash('danger', 'Неверное имя пользователя или пароль.');
Redirect::to('/public/authorization');
exit;
