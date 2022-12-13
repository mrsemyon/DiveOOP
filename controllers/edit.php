<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (!Token::check(Input::get('token'))) {
    Session::flash('danger', 'Что-то пошло не так.');
    Redirect::to('/public/registration');
    exit;
}

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

QueryBuilder::getInstance()->update(
    'users',
    [
        'name'      => Input::get('name'),
        'position'  => Input::get('position'),
        'address'   => Input::get('address'),
        'phone'     => Input::get('phone')
    ],
    ['id' => Input::get('id')]
);

Session::flash('success', 'Информация успешно обновлена.');
Redirect::to("/public/users");
exit;
