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

if ($user['photo'] != 'no_photo.jpg') {
    unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $user['photo']);
}

QueryBuilder::getInstance()->update(
    'users',
    ['photo'    => prepareUserPhoto($_FILES['photo'])],
    ['id'       => Input::get('id')]
);

Session::flash('success', 'Аватар успешно обновлён.');
Redirect::to('/public/users');
exit;
