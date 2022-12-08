<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

$user = QueryBuilder::getInstance()->update(
    'users',
    ['status' => $_POST['status']],
    ['id' => $_GET['id']]
);

Session::flash('success', 'Информация успешно обновлена.');
Redirect::to('/public/users');
exit;
