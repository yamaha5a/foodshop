

<?php
session_start();
?>
<style>
    .input{
        margin-left: -10%;
    }
    .quantity-input {
        width: 50px;
        text-align: center;
    }
</style>

<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Cart</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Cart</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                <table class="table">
    <thead>
        <tr>
            <th scope="col">Sản Phẩm</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Giá</th>
            <th scope="col">Số lượng </th>
            <th scope="col">Tổng số tiền</th>
            <th scope="col"></th>
        </tr>
    </thead>
   <tbody>
    <?php if (!empty($_SESSION['cart'])): ?>
        <?php $totalAll = 0; ?>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <?php
                $total = $item['price'] * $item['quantity'];
                $totalAll += $total;
            ?>
            <tr>
                <td>
                    <img src="upload/<?= htmlspecialchars($item['image']) ?>" width="80" class="rounded-circle" />
                </td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td>
                    <div class="input-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?= $item['id'] ?>, 'decrease')">-</button>
                        <input type="number" class="form-control quantity-input" 
                               id="quantity-<?= $item['id'] ?>"
                               value="<?= $item['quantity'] ?>"
                               min="1" readonly>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?= $item['id'] ?>, 'increase')">+</button>
                    </div>
                </td>
                <td id="product-total-<?= $item['id'] ?>">$<?= number_format($total, 2) ?></td>
                <td>
                    <a href="index.php?page=removeCart&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Xóa sản phẩm</a>
                </td>
            </tr>
        <?php endforeach; ?>

        <!-- Hiển thị tổng tiền -->
        <tr>
            <td colspan="4" class="text-end"><strong>Tổng số tiền:</strong></td>
            <td colspan="2"><strong id="total-amount">$<?= number_format($totalAll, 2) ?></strong></td>
        </tr>

    <?php else: ?>
        <tr>
            <td colspan="6" class="text-center text-muted">🛒 Giỏ hàng của bạn đang trống</td>
        </tr>
    <?php endif; ?>
</tbody>
</table>

                </div>
                <div class="mt-5">
                    <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="mã giảm giá">
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Áp dụng mã giảm giá</button>

                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Giỏ hàng <span class="fw-normal">Tổng</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Tạm tính:</h5>
                                    <p class="mb-0" id="subtotal">$<?= number_format($totalAll, 2) ?></p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Phí vận chuyển:</h5>
                                    <div class="">
                                        <p class="mb-0">Phí cố định: $3.00</p>
                                    </div>
                                </div>
                                <p class="mb-0 text-end">Giao hàng đến :.</p>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Tổng cộng:</h5>
                                <p class="mb-0 pe-4" id="grand-total">$<?= number_format($totalAll + 3.00, 2) ?></p>
                            </div>
                            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button" onclick="proceedToCheckout()">Thanh toán</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
function updateQuantity(id, action) {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('action', action);
    
    fetch('index.php?page=updateCart', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update quantity
            document.getElementById("quantity-" + id).value = data.newQuantity;

            // Update product total
            const productTotalElement = document.getElementById("product-total-" + id);
            if (productTotalElement) {
                productTotalElement.textContent = "$" + data.productTotal;
            }

            // Update all totals
            document.getElementById("total-amount").textContent = "$" + data.totalAll;
            document.getElementById("subtotal").textContent = "$" + data.totalAll;
            document.getElementById("grand-total").textContent = "$" + (parseFloat(data.totalAll) + 3.00).toFixed(2);

            // Show success message
            Toastify({
                text: "Đã cập nhật số lượng",
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: "#28a745",
                stopOnFocus: true
            }).showToast();
        } else {
            Toastify({
                text: data.message || "Có lỗi xảy ra khi cập nhật số lượng",
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: "#dc3545",
                stopOnFocus: true
            }).showToast();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toastify({
            text: "Có lỗi xảy ra khi cập nhật số lượng",
            duration: 3000,
            gravity: "top",
            position: "center",
            backgroundColor: "#dc3545",
            stopOnFocus: true
        }).showToast();
    });
}

function proceedToCheckout() {
    window.location.href = "index.php?page=checkout";
}
</script>




