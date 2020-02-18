<?php

//user functions

function findUserByUsername($username) {
    global $db;

    try {
        $query = $db->prepare('SELECT * from users where username = :username');
        $result->bindParam(':username', $username);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);

    } catch (\Exception $e) {
        throw $e;
    }
}

function createUser($username, $password) {
    global $db;

    try {
        $query = $db->prepare('INSERT INTO users (username, password, role_id) VALUES (:username, :password, 2)' );
        $result->prepare($query);
        $result->bindParam(':username', $username);
        $result->bindParam(':password', $password);
        $result->execute();
        return findUserByEmail($username);

    } catch (\Exception $e) {
        throw $e;
    }
}