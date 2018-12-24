<?php

function hashPassword($password) {
    return password_hash(
        $password,
        PASSWORD_BCRYPT,
        [ "cost" => 10 ]
    );
}

function verifyPassword($password, $hash) {
    return password_verify(
        $password,
        $hash
    );
}

function generateToken($length = 70) {
    $length = ($length < 4) ? 4 : $length;
    return bin2hex(random_bytes(($length - ($length % 2)) / 2));
}
