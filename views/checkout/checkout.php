<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Checkout</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Checkout</li>
    </ol>
</div>
<!-- Single Page Header End -->

<!-- Checkout Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Đơn hàng của bạn</h1>
        <form id="checkoutForm" action="index.php?page=processCheckout" method="POST">
            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-7">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">Tên của bạn<sup>*</sup></label>
                                <input type="text" class="form-control" name="first_name" value="<?= isset($_SESSION['user']['ten']) ? htmlspecialchars($_SESSION['user']['ten']) : '' ?>" required>
                            </div>
                        </div>                       
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Địa chỉ giao hàng<sup>*</sup></label>
                        <input type="text" class="form-control" name="address" placeholder="Số nhà, Tên phường/Xã, Quận/Huyện, Tỉnh " value="<?= isset($_SESSION['user']['diachi']) ? htmlspecialchars($_SESSION['user']['diachi']) : '' ?>" required>
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Số điện thoại<sup>*</sup></label>
                        <input type="tel" class="form-control" name="sodienthoai" value="<?= isset($_SESSION['user']['sodienthoai']) ? htmlspecialchars($_SESSION['user']['sodienthoai']) : '' ?>" required>
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Địa chỉ Email<sup>*</sup></label>
                        <input type="email" class="form-control" name="email" value="<?= isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : '' ?>" required>
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Note<sup>*</sup></label>
                        <textarea name="note" class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Ghi chú (Optional)"></textarea>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-5">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($cartItems) && !empty($cartItems)): ?>
                                    <?php foreach ($cartItems as $item): ?>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center mt-2">
                                                <img src="upload/<?= htmlspecialchars($item['hinhanh1']) ?>" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                            </div>
                                        </th>
                                        <td class="py-5"><?= htmlspecialchars($item['tensanpham']) ?></td>
                                        <td class="py-5">$<?= number_format($item['gia'], 2) ?></td>
                                        <td class="py-5"><?= $item['soluong'] ?></td>
                                        <td class="py-5">$<?= number_format($item['gia'] * $item['soluong'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No items in cart</td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th scope="row"></th>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark py-3">Tổng sản phẩm</p>
                                    </td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                        <p class="mb-0 text-dark">$<?= isset($total) ? number_format($total, 2) : '0.00' ?></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                    </td>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark">$<?= isset($total) ? number_format($total, 2) : '0.00' ?></p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                        <div class="col-12">
                            <h5 class="mb-3">Phương thức thanh toán</h5>
                            <?php foreach ($paymentMethods as $method): ?>
                            <div class="form-check text-start my-3">
                                <input type="radio" class="form-check-input bg-primary border-0" 
                                       id="payment-<?= $method['id'] ?>" 
                                       name="payment_method" 
                                       value="<?= $method['id'] ?>" 
                                       <?= $method['id'] == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="payment-<?= $method['id'] ?>">
                                    <?= htmlspecialchars($method['tenphuongthuc']) ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                        <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(text => {
        try {
            const data = JSON.parse(text);
            if (data.success) {
                window.location.href = 'index.php?page=orders';
            } else {
                throw new Error(data.message || 'Unknown error');
            }
        } catch (e) {
            window.location.href = 'index.php?page=orders';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toastify({
            text: "Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.",
            duration: 3000,
            gravity: "top",
            position: "center",
            backgroundColor: "#dc3545",
            stopOnFocus: true
        }).showToast();
    });
});
</script>

