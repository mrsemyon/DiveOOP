<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$user = QueryBuilder::getInstance()->read('users', ['id' => $_GET['id']]);

if ((Session::get('role') != 'admin') && (Session::get('email') != $user['email'])) {
    Session::flash('danger', 'У Вас недостаточно прав');
    Redirect::to('/public/users.php');
    exit;
}

QueryBuilder::getInstance()->delete('users', ['id' => $_GET['id']]);

if ($user['photo'] != 'no_photo.jpg') {
    unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $user['photo']);
}

Session::flash('success', 'Пользователь успешно удалён.');

if ($user['email'] == Session::get('email')) {
    session_destroy();
    Redirect::to('/public/authorization');
    exit;
}

Redirect::to('/public/users');
exit;
