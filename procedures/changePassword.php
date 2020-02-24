<?php
require_once __DIR__ . '/../inc/bootstrap.php';
requireAuth();

$currentPassword = request()->get('current_password');
$newPassword = request()->get('password');
$confirmedPassword = request()->get('confirm_password');