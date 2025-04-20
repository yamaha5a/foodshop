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
        <div class="card-value"><?= number_format($data['total_revenue'], 0, ',', '.') ?>đ</div>
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
        <div class="card-value"><?= $data['total_products'] ?></div>
        <div class="card-label">Tổng sản phẩm</div>
      </div>
      <div class="card-icon orange">
        <i class="fas fa-box"></i>
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
              <?php if ($order['trangthai'] == 'Khách hàng đã nhận'): ?>
                <span class="status completed">
                  <i class="fas fa-check-circle"></i> Đã hoàn thành
                </span>
              <?php elseif ($order['trangthai'] == 'Chờ xác nhận'): ?>
                <span class="status pending">
                  <i class="fas fa-clock"></i> Chờ xác nhận
                </span>
              <?php elseif ($order['trangthai'] == 'Đang xử lý'): ?>
                <span class="status processing">
                  <i class="fas fa-cog fa-spin"></i> Đang xử lý
                </span>
              <?php elseif ($order['trangthai'] == 'Đang vận chuyển'): ?>
                <span class="status shipping">
                  <i class="fas fa-truck"></i> Đang vận chuyển
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

<style>
.status {
  display: inline-flex;
  align-items: center;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
}

.status i {
  margin-right: 4px;
}

.status.completed {
  background-color: #e6f4ea;
  color: #1e7e34;
}

.status.pending {
  background-color: #fff3cd;
  color: #856404;
}

.status.processing {
  background-color: #cce5ff;
  color: #004085;
}

.status.shipping {
  background-color: #d1ecf1;
  color: #0c5460;
}

.fa-cog.fa-spin {
  animation: fa-spin 2s infinite linear;
}
</style>
