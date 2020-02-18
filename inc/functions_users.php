<?php

//user functions

function findUserByEmail($email) {
    global $db;

    try {
        $query = $db->prepare('SELECT * from users where email = :email');
        $query->bindParam(':email', $email);
        $quey->excute();
        return $query->fetch(PDO::FETCH_ASSOC);

    } catch (\Exception $e) {
        throw $e;
    }

}