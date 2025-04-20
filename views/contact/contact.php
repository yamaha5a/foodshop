<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Contact</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
                <li class="breadcrumb-item"><a href="index.php?page=contact">Pages</a></li>
                <li class="breadcrumb-item active text-white">Contact</li>
            </ol>
        </div>  
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-primary">Liên Hệ Với Chúng Tôi</h1>
                        <p class="mb-4">Nếu bạn có bất kỳ câu hỏi hoặc góp ý nào, vui lòng liên hệ với chúng tôi qua form bên dưới.</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="h-100 rounded">
                        <iframe class="rounded w-100" 
                        style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8138542121787!2d105.7426773356903!3d21.040132898384403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454962c0b6523%3A0x5c76c67564d9d1b9!2zUC4gVHLhu4tuaCBWxINuIELDtCwgSMOgIE7hu5lp!5e0!3m2!1sen!2s!4v1743266238096!5m2!1sen!2s" 
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                
                <?php if (isset($_SESSION['user'])): ?>
                <!-- Form liên hệ cho người dùng đã đăng nhập -->
                <div class="col-lg-7">
                    <form action="index.php?page=sendContact" method="POST" class="">
                        <input type="text" name="tieude" class="w-100 form-control border-0 py-3 mb-4" placeholder="Tiêu đề liên hệ" required>
                        <textarea name="noidung" class="w-100 form-control border-0 mb-4" rows="5" cols="10" placeholder="Nội dung liên hệ" required></textarea>
                        <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary" type="submit">Gửi Liên Hệ</button>
                    </form>
                </div>
                <?php else: ?>
                <!-- Thông báo cho người dùng chưa đăng nhập -->
                <div class="col-lg-7">
                    <div class="alert alert-info">
                        <p class="mb-0">Vui lòng <a href="index.php?page=login">đăng nhập</a> để gửi liên hệ với chúng tôi.</p>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="col-lg-5">
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Địa Chỉ</h4>
                            <p class="mb-2">Trịnh Văn Bô, Hà Nội</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Gửi Email Cho Chúng Tôi</h4>
                            <p class="mb-2">longok.com@gmail.com</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded bg-white">
                        <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Điện Thoại</h4>
                            <p class="mb-2">0378991982</p>
                        </div>
                    </div>
                </div>
                
                <?php if (isset($_SESSION['user']) && !empty($lienHeList)): ?>
                <!-- Hiển thị lịch sử liên hệ cho người dùng đã đăng nhập -->
                <div class="col-12 mt-5">
                    <h2 class="text-primary mb-4">Lịch Sử Liên Hệ</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Tiêu đề</th>
                                    <th>Ngày gửi</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lienHeList as $lienHe): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($lienHe['tieude']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($lienHe['ngaygui'])); ?></td>
                                    <td>
                                        <?php if (empty($lienHe['traloi'])): ?>
                                            <span class="badge bg-warning">Chưa phản hồi</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Đã phản hồi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="index.php?page=contactDetail&id=<?php echo $lienHe['id']; ?>" class="btn btn-sm btn-info">Xem chi tiết</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
