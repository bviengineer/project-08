<?php

require __DIR__ . '/../inc/bootstrap.php';

$password->request()->get('password');
$confirmPassword->request()->get('confirm_password');
$username->request()->get('username');

// Verify if password matches 
if ($password != $confirmPassword) {
    redirect('/register.php'); 
}

// Checks if a user already exists with that username 
$user = findUserByUsername($username);
if (!empty($user)) {
    redirect('/register.php');
}

// Hasing of user password
$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

// Calling create user function
$user = createUser($username, $hashedPwd);

// Redirect user to the home page
redirect('/');