<?php
require_once "connection.php";

function login($email, $password) {
    $sql = "SELECT nguoidung.*, phanquyen.tenquyen FROM nguoidung 
            JOIN phanquyen ON nguoidung.id_phanquyen = phanquyen.id 
            WHERE nguoidung.email = ? LIMIT 1";

    $user = pdo_query_one($sql, $email);

    if ($user && password_verify($password, $user['matkhau'])) {
        return $user;
    }

    return false;
}
