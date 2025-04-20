<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Chi Tiết Liên Hệ</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=contact">Liên Hệ</a></li>
        <li class="breadcrumb-item active text-white">Chi Tiết Liên Hệ</li>
    </ol>
</div>

<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-primary">Chi Tiết Liên Hệ</h1>
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Thông Tin Liên Hệ</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Tiêu đề:</div>
                                <div class="col-md-9"><?php echo htmlspecialchars($lienHe['tieude']); ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Ngày gửi:</div>
                                <div class="col-md-9"><?php echo date('d/m/Y H:i', strtotime($lienHe['ngaygui'])); ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Nội dung:</div>
                                <div class="col-md-9"><?php echo nl2br(htmlspecialchars($lienHe['noidung'])); ?></div>
                            </div>
                            
                            <?php if (!empty($lienHe['traloi'])): ?>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Phản hồi:</div>
                                <div class="col-md-9"><?php echo nl2br(htmlspecialchars($lienHe['traloi'])); ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Ngày phản hồi:</div>
                                <div class="col-md-9"><?php echo date('d/m/Y H:i', strtotime($lienHe['ngaytraloi'])); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer">
                            <a href="index.php?page=contact" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 