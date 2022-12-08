<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$user = QueryBuilder::getInstance()->read('users', ['id' => $_GET['id']]);

if ((Session::get('role') != 'admin') && (Session::get('email') != $user['email'])) {
    Session::flash('danger', 'У Вас недостаточно прав.');
    Redirect::to('/public/users');
    exit;
}

QueryBuilder::getInstance()->update(
    'users',
    [
        'name'      => $_POST['name'],
        'position'  => $_POST['position'],
        'address'   => $_POST['address'],
        'phone'     => $_POST['phone']
    ],
    ['id' => $_GET['id']]
);

Session::flash('success', 'Информация успешно обновлена.');
Redirect::to("/public/users");
exit;
