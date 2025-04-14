
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<style>
.dropdown-menu {
    display: none; /* Ẩn mặc định */
    position: absolute;
    right: 0;
    top: 60px; /* Đẩy menu xuống dưới */
    background: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    overflow: hidden;
    min-width: 150px;
    z-index: 1000;
}
.dropdown-menu.show {
    display: block;
}
.dropdown-item {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #333;
    font-size: 14px;
}
.dropdown-item:hover {
    background: #f5f5f5;
}
.user-profile {
    position: relative;
    cursor: pointer;
    padding: 10px;
}
.profile-container {
    display: flex;
    align-items: center; /* Căn giữa theo chiều dọc */
    gap: 10px; /* Khoảng cách giữa ảnh và tên */
}
.profile-img img {
    width: 40px; /* Kích thước nhỏ hơn */
    height: 40px;
    border-radius: 50%; /* Làm tròn ảnh */
    object-fit: cover; /* Giữ ảnh không bị méo */
    border: 2px solid #ddd; /* Viền nhẹ */
}
.user-info {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: bold;
}

.user-role {
    font-size: 12px;
    color: #666;
}
.clock-card {
    display: flex;
    align-items: center; /* Căn giữa theo chiều dọc */
    margin-right: 20px; /* Khoảng cách với các phần tử khác */
    background-color: #f0f2f5; /* Nền sáng */
    border-radius: 5px; /* Bo góc */
    padding: 5px 10px; /* Padding cho đồng hồ */
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2); /* Đổ bóng nhẹ */
}

.clock-icon {
    margin-right: 5px; /* Khoảng cách giữa biểu tượng và thời gian */
    color: #4a4a4a; /* Màu sắc biểu tượng */
    font-size: 20px; /* Kích thước biểu tượng */
}

.clock {
    font-size: 16px; /* Kích thước chữ nhỏ hơn */
    font-family: 'Courier New', Courier, monospace;
    color: #333; /* Màu sắc chữ đồng hồ */
}

</style>
<div class="header">
    <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search..." />
    </div>
    <div class="header-actions">
        <div class="clock-card">
            <i class="fas fa-clock clock-icon"></i>
            <div class="clock">
                <span id="time">00:00:00</span>
            </div>
        </div>
        <div class="notification">
            <i class="fas fa-bell"></i>
            <div class="badge">3</div>
        </div>
        <div class="notification">
            <i class="fas fa-envelope"></i>
            <div class="badge">5</div>
        </div>
        <div class="user-profile" onclick="toggleDropdown()">
            <div class="profile-container">
                <div class="profile-img">
                    <?php 
                    $imagePath = "http://localhost/shopfood/admin/public/" . $_SESSION['hinhanh'];
                    ?>
                    <img src="<?php echo $imagePath; ?>" alt="Profile">
                </div>
                <div class="user-info">

                    <div class="user-name"><?php echo isset($_SESSION['ten']) ? $_SESSION['ten'] : 'Guest';?></div>
                    <div class="user-role"><?php echo isset($_SESSION['tenquyen']) ? $_SESSION['tenquyen'] : 'Guest';?></div>
                </div>
            </div>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="/shopfood/index.php" class="dropdown-item"><i class="fas fa-home"></i> Trang chủ</a>
                <a href="/shopfood/admin/Views/login/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
            </div>
        </div>
    </div>
</div>

<script>
function toggleDropdown() {
    document.getElementById("dropdownMenu").classList.toggle("show");
}
window.onclick = function(event) {
    if (!event.target.closest(".user-profile")) {
        document.getElementById("dropdownMenu").classList.remove("show");
    }
}

// Cập nhật đồng hồ
const updateClock = () => {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('time').textContent = `${hours}:${minutes}:${seconds}`;
};

// Cập nhật đồng hồ mỗi giây
setInterval(updateClock, 1000);
updateClock(); // Gọi một lần để hiển thị thời gian ngay lập tức
</script>

