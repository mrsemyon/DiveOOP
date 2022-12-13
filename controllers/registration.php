<?php
require $_SERVER['DOCUMENT_ROOT'] . '/app/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, [
            'email' => [
                'required'  => true,
                'email'     => true,
                'unique'    => 'users',
                'min'       => 8,
            ],
            'password' => [
                'required'  => true,
                'min'       => 3
            ],
            'password_again' => [
                'required'  => true,
                'matches'   => 'password'
            ]
        ]);

        if ($validation->isPassed()) {
            QueryBuilder::getInstance()->create(
                'users',
                [
                    'email'     => Input::get('email'),
                    'password'  => password_hash(Input::get('password'), PASSWORD_DEFAULT),
                    'role'      => 'user',
                ]
            );

            Session::put('email', Input::get('email'));
            Session::put('role', 'user');

            Session::flash('success', 'Вы успешно зарегистрированы.');
            Redirect::to('/public/users');
            exit;
        } else {
            foreach ($validation->getErrors() as $error) {
                $errors .= $error . '<br>';
            }
            Session::flash('danger', $errors);
            Redirect::to('/public/registration');
            exit;
        }
    }
}
