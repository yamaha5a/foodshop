<?php
function pdo_get_connection(){
    $dburl = "mysql:host=localhost;dbname=shopfood;charset=utf8";
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO($dburl, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        error_log("Connection failed: " . $e->getMessage());
        return null;
    }
}

function pdo_execute($sql) {
    $sql_args = array_slice(func_get_args(), 1);
    $conn = pdo_get_connection();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($sql_args);
            $conn = null;
            return $result;
        } catch (PDOException $e) {
            error_log("Error executing query: " . $e->getMessage());
            $conn = null;
            return false;
        }
    }
    return false;
}

function pdo_query($sql) {
    $sql_args = array_slice(func_get_args(), 1);
    $conn = pdo_get_connection();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($sql_args);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error executing query: " . $e->getMessage());
            return [];
        } finally {
            $conn = null;
        }
    }
    return [];
}

function pdo_query_one($sql) {
    $sql_args = array_slice(func_get_args(), 1);
    $conn = pdo_get_connection();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($sql_args);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error executing query: " . $e->getMessage());
            return null;
        } finally {
            $conn = null;
        }
    }
    return null;
}

function pdo_query_value($sql) {
    $sql_args = array_slice(func_get_args(), 1);
    $conn = pdo_get_connection();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($sql_args);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? array_values($row)[0] : null;
        } catch (PDOException $e) {
            error_log("Error executing query: " . $e->getMessage());
            return null;
        } finally {
            $conn = null;
        }
    }
    return null;
}
?>
