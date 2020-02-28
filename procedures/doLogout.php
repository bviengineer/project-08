<?php
require __DIR__ . '/../inc/bootstrap.php';

// Log out confirmation message
$session->getFlashBag()->add('success', "Successfully Logged Out");

$accessToken = new \Symfony\Component\HttpFoundation\Cookie('access_token', 'Expired', time()-3600, '/', getenv('COOKIE_DOMAIN'));
        redirect("/login.php", ['cookies'=> [$accessToken]]);