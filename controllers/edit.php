<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

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
