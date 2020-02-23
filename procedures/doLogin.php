<?php 
require __DIR__.'/../inc/bootstrap.php';

// Verifies that the user entered a username
$user = findUserByUsername(request()->get('username'));
if (empty($user)) {
    redirect('/login.php');
}

// Verfies whether the provided password matches the stored hashed password
if (!password_verify(request()->get('password'), $user['password'])) {
    redirect('/login.php');
}

// JWT | JOT
$expireTime = time() + 3600;
$jwt = \Firebase\JWT\JWT::encode([
    'iss' => request()->getBaseUrl(),
    'sub' => "{user['id']}",
    'exp' => $expireTime,
    'iat' => time(),
    'nbf' => time(),
    'is_admin' => $user['role_id'] == 1
], getenv("SECRET_KEY"), 'HS256');

// Cookie
$accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', $jwt, $expireTime, "/", getenv("COOKIE_DOMAIN"));

redirect('/task_list.php', ['cookies' => [$accessToken]]);