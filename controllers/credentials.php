<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$user = QueryBuilder::getInstance()->read('users', ['id' => $_GET['id']]);

if ((Session::get('role') != 'admin') && (Session::get('email') != $user['email'])) {
    Session::flash('danger', 'У Вас недостаточно прав.');
    Redirect::to('/public/users');
    exit;
}

if (empty($_POST['email'])) {
    Session::flash('danger', 'Поле Email не может быть пустым.');
    Redirect::to('/public/credentials', ['id' => $user['id']]);
    exit;
}

if ($user['email'] != $_POST['email']) {
    if (empty(QueryBuilder::getInstance()->read('users', ['email' => $_POST['email']]))) {
        QueryBuilder::getInstance()->update(
            'users',
            ['email' => $_POST['email']],
            ['id' => $_GET['id']]
        );
        if (Session::get('role') != 'admin') {
            Session::put('email', $_POST['email']);
        }
        Session::flash('success', 'Регистрационные данные были обновлены.');
    } else {
        Session::flash('danger', 'Этот адрес занят.');
        Redirect::to('/public/credentials', ['id' => $user['id']]);
        exit;
    }
}

if (!empty($_POST['password'])) {
    QueryBuilder::getInstance()->update(
        'users',
        ['password' => password_hash($_POST['password'], PASSWORD_DEFAULT)],
        ['id' => $_GET['id']]
    );
    Session::put('success', 'Регистрационные данные были обновлены.');
}

if (!Session::exists('success')) {
    Session::flash('danger', 'Регистрационные данные не были обновлены.');
}
Redirect::to('/public/users');
exit;
