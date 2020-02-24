<?php
require_once __DIR__ . '/../inc/bootstrap.php';
requireAuth();

$currentPassword = request()->get('current_password');
$newPassword = request()->get('password');
$confirmedPassword = request()->get('confirm_password');


// Verifies whether new password matches the confirmed version of the new password
if ($newPassword != $confirmedPassword) {
    $session->getFlashBag()->add('error', 'New passwords do not match, please try again');
    redirect('/account.php');
}

// Retrieves user using the 'sub' of the jwt
$user = findUserByAccessToken();

// If a username could not be found 
if (empty($user)) {
    $session->getFlashBag()->add('error', 'Some error Happened. Try again.  If it continues, please 
    log out and log back in.');
    redirect('/account.php');
}

// Verifies whether the password in the database matches the user supplied password
if (!password_verify($currentPassword, $user['password'])) {
    $session->getFlashBag()->add('error', 'Current password is incorrect. Please try again');
    redirect('/account.php');
}

// Hashes the newly updated password
$updated = updatePassword(password_hash($newPassword, PASSWORD_DEFAULT), $user['username']);

// If password could not be updated
if (!$updated) {
    $session->getFlashBag()->add('error', 'Could not update password. Please try again.');
    redirect('/account.php');
}
// Displays success message if the password was updted successfully 
$session->getFlashBag()->add('success', 'Password updated');
redirect('/account.php');