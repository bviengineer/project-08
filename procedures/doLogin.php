<?php 
require __DIR__.'/../inc/bootstrap.php';

// Verifies whether the username provided alreaady exist in the database
$user = findUserByUsername(request()->get('username'));
if (!empty($user)) {
    redirect('/register.php');
}

// Verfies whether the provided password matches the stored hashed password
if (!password_verify(request()->get('password'), $user['password'])) {
    redirect('/login.php');
}