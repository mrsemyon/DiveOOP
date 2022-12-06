<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (!empty(QueryBuilder::getInstance()->read('users', ['email' => $_POST['email']]))) {
    Session::flash('danger', 'Этот эл. адрес уже занят другим пользователем.');
    Redirect::to('/public/create');
    exit;
}

$id = QueryBuilder::getInstance()->create(
    'users',
    [
        'email'     => $_POST['email'],
        'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role'      => 'user',
    ]
);

$photo = (!empty($_FILES['photo']['name']))
    ? prepareUserPhoto($_FILES['photo'])
    : 'no_photo.png';

QueryBuilder::getInstance()->update(
    'users',
    [
        'name'      => $_POST['name'],
        'position'  => $_POST['position'],
        'phone'     => $_POST['phone'],
        'address'   => $_POST['address'],
        'status'    => $_POST['status'],
        'photo'     => $photo,
        'vk'        => $_POST['vk'],
        'tg'        => $_POST['tg'],
        'ig'        => $_POST['ig']
    ],
    ['id' => $id]
);

Session::put('success', 'Пользователь успешно добавлен.');
Redirect::to('/public/users');
exit;
