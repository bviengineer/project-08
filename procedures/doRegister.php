<?php

require __DIR__ . '/../inc/bootstrap.php';

$password->request()->get('password');
$confirmPassword->request()->get('confirm_password');
$username->request()->get('username');

if ($password != $confirmPassword) {
    redirect('/register.php'); 
}

$user = findUserByUsername($username);
if (!empty($user)) {
    redirect('/register.php');
}

// Hasing of user password
$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

// Calilng create user function
$user = createUser($username, $hashedPwd);

// Redirect user to the home page
rediret('/');