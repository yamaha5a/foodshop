<?php
// Kiểm tra nếu session chưa được khởi động thì mới gọi session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="header">
    <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search..." />
    </div>
    <div class="header-actions">
        <div class="notification">
            <i class="fas fa-bell"></i>
            <div class="badge">3</div>
        </div>
        <div class="notification">
            <i class="fas fa-envelope"></i>
            <div class="badge">5</div>
        </div>
        <div class="user-profile">
            <div class="profile-img">
                <?php if (isset($_SESSION['hinhanh']) && $_SESSION['hinhanh'] != ""): ?>
                    <img src="/shopfood/uploads/<?php echo $_SESSION['hinhanh']; ?>" alt="Profile">
                <?php else: ?>
                    <span>JD</span>
                <?php endif; ?>
            </div>
            <div class="user-info">
                <div class="user-name"><?php echo isset($_SESSION['ten']) ? $_SESSION['ten'] : 'Guest'; ?></div>
                <div class="user-role"><?php echo isset($_SESSION['tenquyen']) ? $_SESSION['tenquyen'] : 'Guest'; ?></div>
            </div>  
        </div>
    </div>
</div>
