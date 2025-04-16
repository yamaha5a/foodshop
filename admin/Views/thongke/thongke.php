<div class="stats-cards">
  <div class="stat-card">
    <div class="card-header">
      <div>
        <div class="card-value"><?= $data['total_users'] ?></div>
        <div class="card-label">Tổng số người dùng</div>
      </div>
      <div class="card-icon purple">
        <i class="fas fa-users"></i>
      </div>
    </div>
    <div class="card-change positive">
      <i class="fas fa-arrow-up"></i>
      <span>Tăng 12.5% so với tháng trước</span>
    </div>
  </div>

  <div class="stat-card">
    <div class="card-header">
      <div>
        <div class="card-value">$12,750</div>
        <div class="card-label">Tổng doanh thu</div>
      </div>
      <div class="card-icon blue">
        <i class="fas fa-dollar-sign"></i>
      </div>
    </div>
    <div class="card-change positive">
      <i class="fas fa-arrow-up"></i>
      <span>Tăng 8.2% so với tháng trước</span>
    </div>
  </div>

  <div class="stat-card">
    <div class="card-header">
      <div>
        <div class="card-value"><?= $data['total_orders'] ?></div>
        <div class="card-label">Tổng số đơn hàng</div>
      </div>
      <div class="card-icon green">
        <i class="fas fa-shopping-cart"></i>
      </div>
    </div>
    <div class="card-change negative">
      <i class="fas fa-arrow-down"></i>
      <span>Giảm 3.1% so với tháng trước</span>
    </div>
  </div>

  <div class="stat-card">
    <div class="card-header">
      <div>
        <div class="card-value">85%</div>
        <div class="card-label">Tỷ lệ chuyển đổi</div>
      </div>
      <div class="card-icon orange">
        <i class="fas fa-chart-line"></i>
      </div>
    </div>
    <div class="card-change positive">
      <i class="fas fa-arrow-up"></i>
      <span>Tăng 4.6% so với tháng trước</span>
    </div>
  </div>
</div>

        <!-- Recent Orders -->
        <div class="table-card">
  <div class="card-title">
    <h3><i class="fas fa-shopping-bag"></i> Đơn hàng gần đây</h3>
    <a href="index.php?act=chitiethoadon" class="btn btn-outline btn-sm">
      <i class="fas fa-eye"></i> Xem tất cả
    </a>
  </div>
  <table class="data-table">
    <thead>
      <tr>
        <th>Mã đơn hàng</th>
        <th>Khách hàng</th>
        <th>Ngày</th>
        <th>Số tiền</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($data['recent_orders'])): ?>
        <?php foreach ($data['recent_orders'] as $order): ?>
          <tr>
            <td>#<?= $order['id'] ?></td>
            <td><?= $order['ten_nguoidung'] ?></td>
            <td><?= date('d/m/Y', strtotime($order['ngaytao'])) ?></td>
            <td><?= number_format($order['tongtien'], 0, ',', '.') ?>đ</td>
            <td>
              <?php if ($order['trangthai'] == 'Hoàn thành'): ?>
                <span class="status active">
                  <i class="fas fa-check-circle"></i> Hoàn thành
                </span>
              <?php elseif ($order['trangthai'] == 'Đang chờ xử lý'): ?>
                <span class="status pending">
                  <i class="fas fa-clock"></i> Đang chờ xử lý
                </span>
              <?php else: ?>
                <span class="status cancelled">
                  <i class="fas fa-times-circle"></i> <?= $order['trangthai'] ?>
                </span>
              <?php endif; ?>
            </td>
            <td>
              <a href="index.php?act=detailchitiethoadon&id=<?= $order['id'] ?>" class="btn btn-outline btn-sm">
                <i class="fas fa-eye"></i> Xem
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" class="text-center">Không có đơn hàng nào</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
