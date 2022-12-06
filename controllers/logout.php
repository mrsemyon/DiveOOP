<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

Session::delete('email', $_POST['email']);
Session::delete('role', 'user');

Redirect::to('/public/authorization');
