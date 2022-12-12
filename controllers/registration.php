<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (!Token::check(Input::get('token'))) {
    Session::flash('danger', 'Что-то пошло не так.');
    Redirect::to('/public/registration');
    exit;
}

if (!empty(QueryBuilder::getInstance()->read('users', ['email' => Input::get('email')]))) {
    Session::flash('danger', 'Этот эл. адрес уже занят другим пользователем.');
    Redirect::to('/public/registration');
    exit;
}

QueryBuilder::getInstance()->create(
    'users',
    [
        'email'     => Input::get('email'),
        'password'  => password_hash(Input::get('password'), PASSWORD_DEFAULT),
        'role'      => 'user',
    ]
);

Session::put('email', Input::get('email'));
Session::put('role', 'user');

Session::flash('success', 'Вы успешно зарегистрированы.');
Redirect::to('/public/users');
exit;
