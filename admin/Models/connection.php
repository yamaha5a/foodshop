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
        return null; // Trả về null nếu không thể kết nối
    }
}

function pdo_execute($sql) {
    $sql_args = array_slice(func_get_args(), 1);
    $conn = pdo_get_connection();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($sql_args);
        } catch (PDOException $e) {
            error_log("Error executing query: " . $e->getMessage());
            throw $e; // Ném ngoại lệ để xử lý ở nơi khác
        } finally {
            $conn = null; // Đóng kết nối
        }
    }
}

function pdo_query($sql) {
    $sql_args = array_slice(func_get_args(), 1);
    $conn = pdo_get_connection();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare($sql);
            // Bind parameters with appropriate types
            foreach ($sql_args as $i => $arg) {
                if (is_int($arg)) {
                    $stmt->bindValue($i + 1, $arg, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($i + 1, $arg, PDO::PARAM_STR);
                }
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error executing query: " . $e->getMessage());
            throw $e;
        } finally {
            $conn = null;
        }
    }
    return []; // Trả về mảng rỗng nếu không kết nối
}

function pdo_query_one($sql) {
    $sql_args = array_slice(func_get_args(), 1);
    $conn = pdo_get_connection();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare($sql);
            // Bind parameters with appropriate types
            foreach ($sql_args as $i => $arg) {
                if (is_int($arg)) {
                    $stmt->bindValue($i + 1, $arg, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($i + 1, $arg, PDO::PARAM_STR);
                }
            }
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error executing query: " . $e->getMessage());
            throw $e;
        } finally {
            $conn = null;
        }
    }
    return null; // Trả về null nếu không tìm thấy
}

function pdo_query_value($sql) {
    $sql_args = array_slice(func_get_args(), 1);
    $conn = pdo_get_connection();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare($sql);
            // Bind parameters with appropriate types
            foreach ($sql_args as $i => $arg) {
                if (is_int($arg)) {
                    $stmt->bindValue($i + 1, $arg, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($i + 1, $arg, PDO::PARAM_STR);
                }
            }
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? array_values($row)[0] : null; // Trả về giá trị đầu tiên hoặc null
        } catch (PDOException $e) {
            error_log("Error executing query: " . $e->getMessage());
            throw $e;
        } finally {
            $conn = null;
        }
    }
    return null; // Trả về null nếu không kết nối
}
?>
