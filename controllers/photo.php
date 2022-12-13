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

if ($user['photo'] != 'no_photo.jpg') {
    unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $user['photo']);
}

QueryBuilder::getInstance()->update(
    'users',
    ['photo'    => Photo::prepare($_FILES['photo'])],
    ['id'       => Input::get('id')]
);

Session::flash('success', 'Аватар успешно обновлён.');
Redirect::to('/public/users');
exit;
