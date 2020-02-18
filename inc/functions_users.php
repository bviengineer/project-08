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

function createUser($email, $password) {
    global $db;

    try {
        $query = $db->prepare('INSERT INTO users (email, password, role_id) VALUES (:email, :password, 2)' );
        $result->prepare($query);
        $result->bindParam(':email', $email);
        $result->bindParam(':password', $password);
        $result->execute();
        return findUserByEmail($emamil);

    } catch (\Exception $e) {
        throw $e;
    }
}