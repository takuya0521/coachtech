<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    'passwords' => 'users',

    'username' => 'email',
    'email' => 'email',
    'lowercase_usernames' => true,

    // ログイン後の遷移先を管理画面へ
    'home' => '/admin',

    'prefix' => '',
    'domain' => null,
    'middleware' => ['web'],

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    'views' => true,

    'features' => [
        Features::registration(),
        Features::resetPasswords(),      // パスワードリセット（任意）
        Features::updatePasswords(),     // 任意
        Features::updateProfileInformation(), // 任意
    ],
];
