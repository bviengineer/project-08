<?php 
require __DIR__.'/../inc/bootstrap.php';

$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');
$username = request()->get('username');

// Verify whether passwords match, redirects if different 
if ($password != $confirmPassword) {
    redirect('/register.php'); 
}

// Hasing of user password if existing an existing user is not found 
$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

// Verifies whether a user already exists with that username, redirects if there is 
$user = findUserByUsername($username);
if (!empty($user)) {
    redirect('/register.php');
}

// Adds new user to database if password & username verification steps are successful
$user = createUser($username, $hashedPwd);

// Redirect user to the home page after creating user 
redirect('/');