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
    redirect('/account.php');
}

if (!password_verify($currentPassword, $user['password'])) {
    $session->getFlashBag()->add('error', 'Current password is incorrect. Please try again');
    redirect('/account.php');
}

$updated = updatePassword(password_hash($newPassword, PASSWORD_DEFAULT), $user['id']);

if (!$updated) {
    $session->getFlashBag()->add('error', 'Could not update password. Please try again.');
    redirect('/account.php');
}
$session->getFlashBag()->add('success', 'Password updated');
redirect('/account.php');