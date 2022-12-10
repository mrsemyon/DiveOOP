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

QueryBuilder::getInstance()->delete('users', ['id' => Input::get('id')]);

if ($user['photo'] != 'no_photo.jpg') {
    unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $user['photo']);
}

Session::flash('success', 'Пользователь успешно удалён.');

if ($user['email'] == Session::get('email')) {
    Session::delete('email');
    Session::delete('role');
    Redirect::to('/public/authorization');
    exit;
}

Redirect::to('/public/users');
exit;
