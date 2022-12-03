<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (!empty(QueryBuilder::read('users', ['email' => $_POST['email']]))) {
    Session::flash('danger', 'Этот эл. адрес уже занят другим пользователем.');
    Redirect::to('/public/registration');
    exit;
}

QueryBuilder::create(
    'users',
    [
        'email'     => $_POST['email'],
        'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role'      => 'user',
    ]
);

Session::put('email', $_POST['email']);
Session::put('role', 'user');
Redirect::to('/public/users');
exit;
