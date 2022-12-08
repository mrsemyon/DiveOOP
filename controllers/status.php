<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$user = QueryBuilder::getInstance()->read('users', ['id' => $_GET['id']]);

if ((Session::get('role') != 'admin') && (Session::get('email') != $user['email'])) {
    Session::flash('danger', 'У Вас недостаточно прав.');
    Redirect::to('/public/users');
    exit;
}

$user = QueryBuilder::getInstance()->update(
    'users',
    ['status'   => $_POST['status']],
    ['id'       => $_GET['id']]
);

Session::flash('success', 'Информация успешно обновлена.');
Redirect::to('/public/users');
exit;
