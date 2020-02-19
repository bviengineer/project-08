<?php

//user functions

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

function createUser($username, $password) {
    global $db;

    try {
        $query = $db->prepare('INSERT INTO users (username, password, role_id, task_id) VALUES (:username, :password, 2, 1)' );
        $result = $db->prepare($query);
        $result->bindParam(':username', $username);
        $result->bindParam(':password', $password);
        $result->execute();
        //return findUserByUsername($username);

    } catch (\Exception $e) {
        throw $e;
    }
}