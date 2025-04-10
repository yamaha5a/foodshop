<?php

class BinhLuanModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "shopfood");
        $this->conn->set_charset("utf8mb4");
    }

    public function getAllPaginated($page = 1, $limit = 10, $keyword = '')
    {
        $offset = ($page - 1) * $limit;
        $keyword = $this->conn->real_escape_string($keyword);

        $sql = "SELECT * FROM binhluan WHERE noidung LIKE '%$keyword%' ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $result = $this->conn->query($sql);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getTotalPages($limit = 10, $keyword = '')
    {
        $keyword = $this->conn->real_escape_string($keyword);
        $sql = "SELECT COUNT(*) as total FROM binhluan WHERE noidung LIKE '%$keyword%'";
        $result = $this->conn->query($sql);
        $total = $result->fetch_assoc()['total'];
        return ceil($total / $limit);
    }

    public function getOne($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM binhluan WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM binhluan WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
