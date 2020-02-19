<?php 
require __DIR__.'/../inc/bootstrap.php';

$user = findUserByUsername(request()->get('username'));
if (!empty($user)) {
    redirect('/register.php');
}