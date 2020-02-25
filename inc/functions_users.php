<?php

//user functions

// Fin a user by username
function findUserByUsername($username) {
    global $db;
    try {
        $query = $db->prepare('SELECT * from users where username = :username');
        $query->bindParam(':username', $username);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (\Exception $e) {
        throw $e;
    }
}
// Find a user by acess token
function findUserByAccessToken() {
    global $db;

    try {
        $userName = decodeJwt('sub');
    } catch (\Exception $e) {
        throw $e;
    }
    try {
        $query = $db->prepare('SELECT * from users where username = :userName');
        $query->bindParam(':userName', $userName);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (\Exception $e) {
        throw $e;
    }
}
// Create a new user account
function createUser($username, $password) {
    global $db;
    try {
        $query = $db->prepare('INSERT INTO users (username, password, role_id, task_id) VALUES (:username, :password, 2, 1)' );
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $password);
        $query->execute();
        return findUserByUsername($username);
    } catch (\Exception $e) {
        throw $e;
    }
}
// Update a user's password
function updatePassword($password, $userId) {
    global $db;

    try {
        $query = $db->prepare('UPDATE users SET password = :password WHERE username = :userId');
        $query->bindParam(':password', $password);
        $query->bindParam(':userId', $userId);
        $query->execute();
    } catch (\Exception $e) {
        return false;
    }
    return true;
}
// Decode the JWT/JOT
function decodeJwt($prop = null) {
    \Firebase\JWT\JWT::$leeway = 1;
    $jwt = \Firebase\JWT\JWT::decode(
        request()->cookies->get('access_token'),
        getenv('SECRET_KEY'),
        ['HS256']
    );

    if ($prop === null) {
        return $jwt;
    }
    
    return $jwt->{$prop};
}
// Verifies whether a user is autenticated 
function isAuthenticated() {
    if (!request()->cookies->has('access_token')) {
        return false;
    }

    try {
        decodeJwt();
        return true;
    } catch (\Exception $e) {
        return false;
    }
}
// Require a user to authenticate
function requireAuth() {
    if (!isAuthenticated()) {
        $accessToken = new \Symfony\Component\HttpFoundation\Cookie('access_token', 'Expired', time()-3600, '/', getenv('COOKIE_DOMAIN'));
        redirect("/login.php", ['cookies' => [$accessToken]]);
    }
}
// Displays getFlashBag errors
function display_errors() {
    global $session;

    if (!$session->getFlashBag()->has('error')) {
        return;
    }
    $messages = $session->getFlashBag()->get('error');
    $response = '<div class="alert alert-danger alert-dismissable">';
    foreach ($messages as $message) {
        $response .= "$message <br>";
    }
    $response .= '</div>';
    return $response;
}
// Displays getFlashBag success messages
// Obtained from course notes: https://teamtreehouse.com/library/user-profile-2
function display_success() {
    global $session;

    if(!$session->getFlashBag()->has('success')) {
        return;
    }

    $messages = $session->getFlashBag()->get('success');

    $response = '<div class="alert alert-success alert-dismissable">';
    foreach ($messages as $message) {
        $response .= "$message <br>";
    }
    $response .= '</div>';

    return $response;
}