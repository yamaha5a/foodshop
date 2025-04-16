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
        <?php if (empty($cartItems)): ?>
            <div class="text-center">
                <h2 class="mb-4">Giỏ hàng của bạn đang trống</h2>
                <p class="mb-4">Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán</p>
                <a href="index.php?page=product" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <h1 class="mb-4">Đơn hàng của bạn</h1>
            <form id="checkoutForm" action="index.php?page=processCheckout" method="POST">
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Tên của bạn<sup>*</sup></label>
                                    <input type="text" class="form-control" name="first_name" value="<?= isset($_SESSION['user']['ten']) ? htmlspecialchars($_SESSION['user']['ten']) : '' ?>" required>
                                    <div class="invalid-feedback" id="first_name_error"></div>
                                </div>
                            </div>                       
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Địa chỉ giao hàng<sup>*</sup></label>
                            <input type="text" class="form-control" name="address" placeholder="Số nhà, Tên phường/Xã, Quận/Huyện, Tỉnh " value="<?= isset($_SESSION['user']['diachi']) ? htmlspecialchars($_SESSION['user']['diachi']) : '' ?>" required>
                            <div class="invalid-feedback" id="address_error"></div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Số điện thoại<sup>*</sup></label>
                            <input type="tel" class="form-control" name="sodienthoai" value="<?= isset($_SESSION['user']['sodienthoai']) ? htmlspecialchars($_SESSION['user']['sodienthoai']) : '' ?>" required>
                            <div class="invalid-feedback" id="sodienthoai_error"></div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Địa chỉ Email<sup>*</sup></label>
                            <input type="email" class="form-control" name="email" value="<?= isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : '' ?>" required>
                            <div class="invalid-feedback" id="email_error"></div>
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
                                        <?php foreach ($cartItems as $index => $item): ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="upload/<?= htmlspecialchars($item['hinhanh1']) ?>" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                                </div>
                                            </th>
                                            <td class="py-5"><?= htmlspecialchars($item['tensanpham']) ?></td>
                                            <td class="py-5">$<?= number_format($item['gia'], 2) ?></td>
                                            <td class="py-5"><?= $item['soluong'] ?></td>
                                            <td class="py-5">$<?= number_format(($item['gia'] + ($item['gia_topping'] ?? 0)) * $item['soluong'], 2) ?></td>
                                        </tr>
                                        <!-- Add hidden fields for each cart item -->
                                        <input type="hidden" name="cart_items[<?= $index ?>][id_sanpham]" value="<?= $item['id_sanpham'] ?>">
                                        <input type="hidden" name="cart_items[<?= $index ?>][soluong]" value="<?= $item['soluong'] ?>">
                                        <input type="hidden" name="cart_items[<?= $index ?>][gia]" value="<?= $item['gia'] ?>">
                                        <input type="hidden" name="cart_items[<?= $index ?>][id_topping]" value="<?= $item['id_topping'] ?? '' ?>">
                                        <input type="hidden" name="cart_items[<?= $index ?>][gia_topping]" value="<?= $item['gia_topping'] ?? '' ?>">
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
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="1" checked>
                                    <label class="form-check-label" for="payment_cod">Thanh toán khi nhận hàng (COD)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_bank" value="2">
                                    <label class="form-check-label" for="payment_bank">Chuyển khoản ngân hàng</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    // Reset error messages
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
    
    let isValid = true;
    
    // Validate first name
    const firstName = document.querySelector('input[name="first_name"]');
    if (!/^[a-zA-Z\sÀ-ỹ]+$/.test(firstName.value)) {
        document.getElementById('first_name_error').textContent = 'Tên không được chứa số hoặc ký tự đặc biệt';
        firstName.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validate address
    const address = document.querySelector('input[name="address"]');
    if (!/^[a-zA-Z0-9\sÀ-ỹ,./]+$/.test(address.value)) {
        document.getElementById('address_error').textContent = 'Địa chỉ không được chứa ký tự đặc biệt';
        address.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validate phone number
    const phone = document.querySelector('input[name="sodienthoai"]');
    if (!/^0\d{9}$/.test(phone.value)) {
        document.getElementById('sodienthoai_error').textContent = 'Số điện thoại phải bắt đầu bằng 0 và có 10 chữ số';
        phone.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validate email
    const email = document.querySelector('input[name="email"]');
    if (!email.value.endsWith('@gmail.com')) {
        document.getElementById('email_error').textContent = 'Email phải kết thúc bằng @gmail.com';
        email.classList.add('is-invalid');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});
</script>