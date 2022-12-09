<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$user = QueryBuilder::getInstance()->read('users', ['id' => $_GET['id']]);

if ((Session::get('role') != 'admin') && (Session::get('email') != $user['email'])) {
    Session::flash('danger', 'У Вас недостаточно прав.');
    Redirect::to('/public/users');
    exit;
}

if ($user['photo'] != 'no_photo.jpg') {
    unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $user['photo']);
}

$photo = (!empty($_FILES['photo']['name']))
    ? prepareUserPhoto($_FILES['photo'])
    : 'no_photo.jpg';

QueryBuilder::getInstance()->update(
    'users',
    ['photo'    => $photo],
    ['id'       => $_GET['id']]
);

Session::flash('success', 'Аватар успешно обновлён.');
Redirect::to('/public/users');
exit;
