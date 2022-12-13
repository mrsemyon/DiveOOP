<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, [
            'email' => [
                'required'  => true,
                'email'     => true,
            ],
            'password' => [
                'required'  => true,
            ]
        ]);

        if ($validation->isPassed()) {
            $user = QueryBuilder::getInstance()->read('users', ['email' => Input::get('email')]);

            if (!empty($user) && password_verify(Input::get('password'), $user['password'])) {
                Session::put('email', Input::get('email'));
                Session::put('role', $user['role']);
                Session::flash('success', 'Авторизация прошла успешно.');
                Redirect::to('/public/users');
                exit;
            }
        } else {
            foreach ($validation->getErrors() as $error) {
                $errors .= $error . '<br>';
            }
            Session::flash('danger', $errors);
            Redirect::to('/public/authorization');
            exit;
        }
    }
}

Session::flash('danger', 'Неверное имя пользователя или пароль.');
Redirect::to('/public/authorization');
exit;
