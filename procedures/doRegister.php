<?php

require __DIR__ . '/../inc/bootstrap.php';

$password->requet()->get('password');
$confirmPassword->requet()->get('confirm_password');
$email->requet()->get('email');

if ($password != $confirmPassword) {
    redirect('/register.php'); 
}

$user = findUserByEmail($email);
if (!empty($user)) {
    redirect('/register.php');
}