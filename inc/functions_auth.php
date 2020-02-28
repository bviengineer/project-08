<?php
function isAuthenticated() {
    global $session;
    return $session->get('auth_logged_in', false);
}

function saveUserSession($user) {
    global $session;

    $session->set('auth_logged_in', true);
    $session->set('auth_user_id', $user['id']);
    
    $session->getFlashBag()->add('success', 'Successfuly Logged On');
}