<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

Session::delete('email');
Session::delete('role');

Redirect::to('/public/authorization');
