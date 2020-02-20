<?php
require __DIR__ . '/../inc/boostrap.php';

$accessToken = new \Symfony\Component\HttpFoundation\Cookie('access_token', 'Expired', time()-3600, '/', getenv('COOKIE_DOMAIN'));
        redirect("/login.php", ['cookies'=> [$accessToken]]);