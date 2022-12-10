<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (Input::exists('get')) {
    $user = QueryBuilder::getInstance()->read('users', ['id' => Input::get('id')]);
} else {
    Session::flash('danger', 'Внутренняя ошибка сервера.');
    Redirect::to('/public/users');
    exit;
}

if ((Session::get('role') != 'admin') && (Session::get('email') != $user['email'])) {
    Session::flash('danger', 'У Вас недостаточно прав.');
    Redirect::to('/public/users');
    exit;
}

if (empty(Input::get('email'))) {
    Session::flash('danger', 'Поле Email не может быть пустым.');
    Redirect::to('/public/credentials', ['id' => $user['id']]);
    exit;
}

if ($user['email'] != Input::get('email')) {
    if (empty(QueryBuilder::getInstance()->read('users', ['email' => Input::get('email')]))) {
        QueryBuilder::getInstance()->update(
            'users',
            ['email' => Input::get('email')],
            ['id' => Input::get('id')]
        );
        if (Session::get('role') != 'admin') {
            Session::put('email', Input::get('email'));
        }
        Session::flash('success', 'Регистрационные данные были обновлены.');
    } else {
        Session::flash('danger', 'Этот адрес занят.');
        Redirect::to('/public/credentials', ['id' => $user['id']]);
        exit;
    }
}

if (!empty(Input::get('password'))) {
    QueryBuilder::getInstance()->update(
        'users',
        ['password' => password_hash(Input::get('password'), PASSWORD_DEFAULT)],
        ['id' => Input::get('id')]
    );
    Session::put('success', 'Регистрационные данные были обновлены.');
}

if (!Session::exists('success')) {
    Session::flash('danger', 'Регистрационные данные не были обновлены.');
}
Redirect::to('/public/users');
exit;
