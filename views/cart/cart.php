<style>
    .input{
        margin-left: -10%;
    }
    .quantity-input {
        width: 50px;
        text-align: center;
    }
</style>
<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Cart</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Cart</li>
    </ol>
</div>

<div class="container-fluid py-5">
    <div class="container py-5">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['success_message'];
                    unset($_SESSION['success_message']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sản Phẩm</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Tổng số tiền</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cartItems)): ?>
                        <?php $totalAll = 0; ?>
                        <?php foreach ($cartItems as $item): ?>
                            <?php
                                $total = $item['gia'] * $item['soluong'];
                                $totalAll += $total;
                            ?>
                            <tr>
                                <td>
                                    <img src="upload/<?= htmlspecialchars($item['hinhanh1']) ?>" width="80" class="rounded-circle" />
                                </td>
                                <td><?= htmlspecialchars($item['tensanpham']) ?></td>
                                <td>
                                    <?php if ($item['is_discounted']): ?>
                                        <span class="text-decoration-line-through text-muted"><?= number_format($item['gia_goc'], 0, ',', '.') ?> VNĐ</span><br>
                                        <span id="price-<?= $item['id_sanpham'] ?>" class="text-danger fw-bold discounted" 
                                              data-original-price="<?= $item['gia_goc'] ?>" 
                                              data-discounted-price="<?= $item['gia'] ?>">
                                            <?= number_format($item['gia'], 0, ',', '.') ?> VNĐ
                                        </span>
                                    <?php else: ?>
                                        <span id="price-<?= $item['id_sanpham'] ?>">
                                            <?= number_format($item['gia'], 0, ',', '.') ?> VNĐ
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?= $item['id_sanpham'] ?>, 'decrease')">-</button>
                                        <input type="number" class="form-control quantity-input" 
                                               id="quantity-<?= $item['id_sanpham'] ?>"
                                               value="<?= $item['soluong'] ?>"
                                               min="1" 
                                               onchange="updateQuantity(<?= $item['id_sanpham'] ?>, 'change', this.value)"
                                               onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109"
                                               data-available="<?= $item['soluong_kho'] ?>">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?= $item['id_sanpham'] ?>, 'increase')">+</button>
                                    </div>
                                    <small class="text-muted d-block mt-1">Còn lại: <?= $item['soluong_kho'] ?> sản phẩm</small>
                                </td>
                                <td id="product-total-<?= $item['id_sanpham'] ?>"><?= number_format($total, 0, ',', '.') ?> VNĐ</td>
                                <td>
                                    <a href="index.php?page=removeCart&id=<?= $item['id_sanpham'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa sản phẩm</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td colspan="4" class="text-end"><strong>Tổng số tiền:</strong></td>
                            <td colspan="2"><strong id="total-amount"><?= number_format($totalAll, 0, ',', '.') ?> VNĐ</strong></td>
                        </tr>

                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">🛒 Giỏ hàng của bạn đang trống</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Giỏ hàng <span class="fw-normal">Tổng</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Tạm tính:</h5>
                            <p class="mb-0" id="subtotal"><?= number_format($totalAll, 0, ',', '.') ?> VNĐ</p>
                        </div>
                        <?php 
                        // Calculate total savings from discounted products
                        $totalSavings = 0;
                        foreach ($cartItems as $item) {
                            if ($item['is_discounted']) {
                                $totalSavings += ($item['gia_goc'] - $item['gia']) * $item['soluong'];
                            }
                        }
                        ?>
                        <?php if ($totalSavings > 0): ?>
                            <div class="d-flex justify-content-between mb-4" id="savings-row">
                                <h5 class="mb-0 me-4">Tiết kiệm từ sản phẩm giảm giá:</h5>
                                <p class="mb-0 text-success" id="savings">-<?= number_format($totalSavings, 0, ',', '.') ?> VNĐ</p>
                            </div>
                        <?php else: ?>
                            <div class="d-flex justify-content-between mb-4" id="savings-row" style="display: none;">
                                <h5 class="mb-0 me-4">Tiết kiệm từ sản phẩm giảm giá:</h5>
                                <p class="mb-0 text-success" id="savings">-0 VNĐ</p>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['discount'])): ?>
                            <div class="d-flex justify-content-between" id="discountRow">
                                <h5 class="mb-0 me-4">Giảm giá:</h5>
                                <p class="mb-0" id="discountAmount">-<?= number_format($_SESSION['discount']['amount'], 0, ',', '.') ?> VNĐ</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Tổng cộng:</h5>
                        <p class="mb-0 pe-4" id="grand-total">
                            <?php 
                                $total = $totalAll;
                                if (isset($_SESSION['discount']) && isset($_SESSION['discount']['newTotal'])) {
                                    $total = $_SESSION['discount']['newTotal'];
                                }
                                echo number_format($total, 0, ',', '.') . ' VNĐ';
                            ?>
                        </p>
                    </div>
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button" onclick="proceedToCheckout()">Thanh toán</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateQuantity(productId, action, newValue = null) {
    const input = document.getElementById(`quantity-${productId}`);
    let quantity = parseInt(input.value);
    
    if (action === 'increase') {
        // Get the available quantity from the data attribute
        const availableQuantity = parseInt(input.getAttribute('data-available') || '100');
        if (quantity < availableQuantity) {
            quantity++;
            input.value = quantity;
        } else {
            // Show specific error message for maximum stock reached
            Swal.fire({
                title: 'Đã đạt tối đa!',
                text: `Sản phẩm đã đạt số lượng tối đa trong kho (${availableQuantity})`,
                icon: 'info',
                confirmButtonText: 'OK'
            });
            return;
        }
    } else if (action === 'decrease' && quantity > 1) {
        quantity--;
        input.value = quantity;
    } else if (action === 'change' && newValue !== null) {
        quantity = parseInt(newValue);
        const availableQuantity = parseInt(input.getAttribute('data-available') || '100');
        if (quantity < 1) quantity = 1;
        if (quantity > availableQuantity) {
            quantity = availableQuantity;
            input.value = quantity;
            // Show specific error message for maximum stock reached
            Swal.fire({
                title: 'Đã đạt tối đa!',
                text: `Sản phẩm đã đạt số lượng tối đa trong kho (${availableQuantity})`,
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    }
    
    // Update quantity in database
    fetch('index.php?page=updateCart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&quantity=${quantity}`
    })
    .then(response => {
        if (response.ok) {
            // Cập nhật tổng tiền của sản phẩm
            const price = <?= $item['gia'] ?>;
            const total = price * quantity;
            document.getElementById(`product-total-${productId}`).textContent = `${total.toLocaleString('vi-VN')} VNĐ`;
            
            // Cập nhật tổng tiền của giỏ hàng
            updateCartTotal();

            // Hiển thị thông báo thành công
            Swal.fire({
                title: 'Thành công!',
                text: 'Đã cập nhật số lượng thành công',
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 1500,
                showConfirmButton: false
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Lỗi!',
            text: 'Có lỗi xảy ra khi cập nhật số lượng',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}

function updateCartTotal() {
    let totalAll = 0;
    let totalSavings = 0;
    
    document.querySelectorAll('[id^="product-total-"]').forEach(element => {
        const total = parseFloat(element.textContent.replace(/[^\d]/g, ''));
        totalAll += total;
        
        // Check if this is a discounted product
        const productId = element.id.split('-')[2];
        const priceElement = document.querySelector(`#price-${productId}`);
        if (priceElement && priceElement.classList.contains('discounted')) {
            const originalPrice = parseFloat(priceElement.getAttribute('data-original-price'));
            const discountedPrice = parseFloat(priceElement.getAttribute('data-discounted-price'));
            const quantity = parseInt(document.getElementById(`quantity-${productId}`).value);
            totalSavings += (originalPrice - discountedPrice) * quantity;
        }
    });
    
    // Update subtotal
    document.getElementById('total-amount').textContent = `${totalAll.toLocaleString('vi-VN')} VNĐ`;
    document.getElementById('subtotal').textContent = `${totalAll.toLocaleString('vi-VN')} VNĐ`;
    
    // Update savings if any
    const savingsElement = document.getElementById('savings');
    if (savingsElement && totalSavings > 0) {
        savingsElement.textContent = `-${totalSavings.toLocaleString('vi-VN')} VNĐ`;
        document.getElementById('savings-row').style.display = 'flex';
    } else if (savingsElement) {
        document.getElementById('savings-row').style.display = 'none';
    }
    
    // Update grand total (with discount if applicable)
    let grandTotal = totalAll;
    if (document.getElementById('discountRow')) {
        const discountAmount = parseFloat(document.getElementById('discountAmount').textContent.replace(/[^\d]/g, ''));
        grandTotal = totalAll - discountAmount;
    }
    
    document.getElementById('grand-total').textContent = `${grandTotal.toLocaleString('vi-VN')} VNĐ`;
}

function proceedToCheckout() {
    window.location.href = 'index.php?page=checkout';
}

function applyDiscount() {
    var code = $('#discount-code').val();
    if (!code) {
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: 'Vui lòng nhập mã giảm giá'
        });
        return;
    }

    $.ajax({
        url: 'index.php?page=applyDiscount',
        type: 'POST',
        data: { code: code },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: response.message
                });
                
                // Cập nhật hiển thị giảm giá
                var discount = response.discount;
                $('#discount-amount').text(formatMoney(discount.amount));
                $('#final-total').text(formatMoney(discount.finalTotal));
                $('#discount-percent').text(discount.percent + '%');
                
                // Hiển thị thông tin giảm giá
                $('.discount-info').show();
                $('.discount-code').text(discount.code);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: response.message
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Có lỗi xảy ra, vui lòng thử lại sau'
            });
        }
    });
}

function formatMoney(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

function removeFromCart(productId) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Bạn sẽ không thể hoàn tác hành động này!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có, xóa nó!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            // Gửi request xóa sản phẩm
            window.location.href = 'index.php?page=removeCart&id=' + productId;
        }
    });
}

// Hiển thị thông báo từ session nếu có
<?php if (isset($_SESSION['success_message'])): ?>
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: '<?= $_SESSION['success_message'] ?>',
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 1500,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <script>
        Swal.fire({
            title: 'Lỗi!',
            text: '<?= $_SESSION['error_message'] ?>',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>
</script>






