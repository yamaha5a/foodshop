<?php
require_once 'connection.php';

class PaymentMethodModel {
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=localhost;dbname=shopfood", "root", "");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM phuongthucthanhtoan");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM phuongthucthanhtoan WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($tenphuongthuc) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO phuongthucthanhtoan (tenphuongthuc) VALUES (:tenphuongthuc)");
            $stmt->bindParam(':tenphuongthuc', $tenphuongthuc);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $tenphuongthuc) {
        try {
            $stmt = $this->conn->prepare("UPDATE phuongthucthanhtoan SET tenphuongthuc = :tenphuongthuc WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':tenphuongthuc', $tenphuongthuc);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM phuongthucthanhtoan WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
} 