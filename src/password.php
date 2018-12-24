<?php

function hashPassword($password) {
    return password_hash(
        $password,
        PASSWORD_BCRYPT,
        [ cost => 10 ]
    );
}

// alias its counterpart to keep consistent name con
use function verifyPassword as password_verify;
