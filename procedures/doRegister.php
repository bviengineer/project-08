<?php 
require __DIR__.'/../inc/bootstrap.php';

$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');
$username = request()->get('username');

// Verify whether passwords match, redirects if different 
if ($password != $confirmPassword) {
    $session->getFlashBag()->add('error', 'Passwords do not match. Please try again.');
    redirect('/register.php'); 
}

// Hasing of user password if existing an existing user is not found 
$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

// Verifies whether a user already exists with that username, redirects if there is 
$user = findUserByUsername($username);
if (!empty($user)) {
    $session->getFlashBag()->add('error', 'Username already in use. Please try again.');
    redirect('/register.php');
}

// Adds new user to database if password & username verification steps are successful
$user = createUser($username, $hashedPwd);

// Registration success and logged in confirmation message
$session->getFlashBag()->add('success', "Account Created! You are Logged In.");

// Redirect user to the home page after creating user 
redirect('/');