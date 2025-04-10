<?php
class PhuongThucThanhToanModel {
    public function getAll() {
        return pdo_query("SELECT * FROM phuongthucthanhtoan ORDER BY id DESC");
    }

    public function getOne($id) {
        return pdo_query_one("SELECT * FROM phuongthucthanhtoan WHERE id = ?", $id);
    }

    public function insert($tenpt) {
        pdo_execute("INSERT INTO phuongthucthanhtoan (tenphuongthuc) VALUES (?)", $tenpt);
    }

    public function update($id, $tenpt) {
        pdo_execute("UPDATE phuongthucthanhtoan SET tenphuongthuc = ? WHERE id = ?", $tenpt, $id);
    }

    public function delete($id) {
        pdo_execute("DELETE FROM phuongthucthanhtoan WHERE id = ?", $id);
    }
}
?>
