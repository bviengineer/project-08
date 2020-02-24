<?php
require_once __DIR__ . '/../inc/bootstrap.php';
requireAuth();

$currentPassword = request()->get('current_password');
$newPassword = request()->get('password');
$confirmedPassword = request()->get('confirm_password');

if ($newPassword != $confirmedPassword) {
    $session->getFlashBag()->add('error', 'New passwords do not match, please try again');
    redirect('/account.php');
}

$user = findUserByAccessToken();
if (empty($user)) {
    $session->getFlashBag()->add('error', 'Some error Happened. Try again.  If it continues, please log out and log back in.');
    redirect('/acoount.php');
}