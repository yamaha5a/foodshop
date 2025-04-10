<style>
    .ptt-container {
        padding: 2rem;
        font-family: Arial, sans-serif;
    }

    .ptt-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .ptt-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
    }

    .ptt-header a {
        padding: 0.5rem 1rem;
        background-color: #1d4ed8;
        color: #fff;
        text-decoration: none;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease;
    }

    .ptt-header a:hover {
        background-color: #2563eb;
    }

    form input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        outline: none;
        transition: border-color 0.3s ease;
    }

    form input:focus {
        border-color: #2563eb;
    }

    form button {
        padding: 0.5rem 1rem;
        background-color: #1d4ed8;
        color: white;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    form button:hover {
        background-color: #2563eb;
    }
</style>

<div class="ptt-container">
    <div class="ptt-header">
        <h2>Sửa phương thức thanh toán</h2>
        <a href="index.php?act=phuongthucthanhtoan">Quay lại danh sách</a>
    </div>

    <form action="index.php?act=phuongthucthanhtoan&action=update&id=<?= $data['id'] ?>" method="POST">
        <div style="margin-bottom: 1rem;">
            <label for="tenphuongthuc" class="block mb-1 font-medium">Tên phương thức:</label>
            <input type="text" name="tenphuongthuc" id="tenphuongthuc"
                   value="<?= htmlspecialchars($data['tenphuongthuc']) ?>" required>
        </div>
        <button type="submit">Cập nhật</button>
    </form>
</div>
