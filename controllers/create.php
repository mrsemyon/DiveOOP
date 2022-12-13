<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (!Token::check(Input::get('token'))) {
    Session::flash('danger', 'Что-то пошло не так.');
    Redirect::to('/public/registration');
    exit;
}

if (Session::get('role') != 'admin') {
    Session::flash('danger', 'У Вас недостаточно прав.');
    Redirect::to("/public/users");
    exit;
}

if (!empty(QueryBuilder::getInstance()->read('users', ['email' => Input::get('email')]))) {
    Session::flash('danger', 'Этот эл. адрес уже занят другим пользователем.');
    Redirect::to('/public/create');
    exit;
}

$id = QueryBuilder::getInstance()->create(
    'users',
    [
        'email'     => Input::get('email'),
        'password'  => password_hash(Input::get('password'), PASSWORD_DEFAULT),
        'role'      => 'user',
    ]
);

QueryBuilder::getInstance()->update(
    'users',
    [
        'name'      => Input::get('name'),
        'position'  => Input::get('position'),
        'phone'     => Input::get('phone'),
        'address'   => Input::get('address'),
        'status'    => Input::get('status'),
        'vk'        => Input::get('vk'),
        'tg'        => Input::get('tg'),
        'ig'        => Input::get('ig'),
        'photo'     => Photo::prepare($_FILES['photo'])
    ],
    ['id' => $id]
);

Session::put('success', 'Пользователь успешно добавлен.');
Redirect::to('/public/users');
exit;
