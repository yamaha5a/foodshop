<?php
// Remove the check that's causing the page to not load
?>

<style>
    .about-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('upload/about-hero.jpg');
        background-size: cover;
        background-position: center;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-bottom: 50px;
    }

    .about-section {
        padding: 50px 0;
    }

    .about-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }

    .about-card:hover {
        transform: translateY(-5px);
    }

    .about-icon {
        font-size: 40px;
        color: #3CB815;
        margin-bottom: 20px;
    }

    .team-member {
        text-align: center;
        margin-bottom: 30px;
    }

    .team-member img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        margin-bottom: 20px;
        object-fit: cover;
    }

    .achievement-number {
        font-size: 3rem;
        font-weight: bold;
        color: #3CB815;
    }
</style>
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Về Chúng Tôi</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Về Chúng Tôi</li>
    </ol>
</div>
<!-- Main Content -->
<div class="container">
    <!-- Our Story Section -->
    <div class="about-section">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="mb-4">Câu Chuyện Của Chúng Tôi</h2>
                <p class="text-muted">ShopFood được thành lập vào năm 2025 với sứ mệnh mang đến những trải nghiệm ẩm thực tuyệt vời nhất cho khách hàng. Chúng tôi không chỉ đơn thuần là một cửa hàng thức ăn online, mà còn là nơi kết nối những người đam mê ẩm thực.</p>
                <p class="text-muted">Với đội ngũ đầu bếp chuyên nghiệp và quy trình chọn lọc nguyên liệu nghiêm ngặt, chúng tôi cam kết mang đến những món ăn không chỉ ngon miệng mà còn đảm bảo vệ sinh an toàn thực phẩm.</p>
            </div>
            <div class="col-lg-6">
                <img src="upload/db.jpg" alt="Our Story" class="img-fluid rounded">
            </div>
        </div>
    </div>

    <!-- Our Values Section -->
    <div class="about-section">
        <h2 class="text-center mb-5">Giá Trị Cốt Lõi</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="about-card text-center">
                    <div class="about-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4>Chất Lượng</h4>
                    <p>Cam kết mang đến những món ăn chất lượng cao nhất với nguồn nguyên liệu tươi ngon.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-card text-center">
                    <div class="about-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>Nhanh Chóng</h4>
                    <p>Giao hàng nhanh chóng, đảm bảo món ăn đến tay khách hàng trong thời gian ngắn nhất.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-card text-center">
                    <div class="about-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>An Toàn</h4>
                    <p>Đảm bảo vệ sinh an toàn thực phẩm là ưu tiên hàng đầu của chúng tôi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements Section -->
    <div class="about-section bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Thành Tựu Của Chúng Tôi</h2>
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="achievement-number">5000+</div>
                    <p>Khách Hàng Hài Lòng</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="achievement-number">100+</div>
                    <p>Món Ăn Đa Dạng</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="achievement-number">50+</div>
                    <p>Đầu Bếp Chuyên Nghiệp</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="achievement-number">4.9</div>
                    <p>Đánh Giá Trung Bình</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Team Section -->
    <div class="about-section">
        <h2 class="text-center mb-5">Đội Ngũ Của Chúng Tôi</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="team-member">
                    <img src="upload/team-1.jpg" alt="Team Member">
                    <h4>Nguyễn Văn A</h4>
                    <p class="text-muted">Bếp Trưởng</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-member">
                    <img src="upload/team-2.jpg" alt="Team Member">
                    <h4>Trần Thị B</h4>
                    <p class="text-muted">Quản Lý Chất Lượng</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-member">
                    <img src="upload/helo.jpg" alt="Team Member">
                    <h4>Nguyễn Trọng Đức Long</h4>
                    <p class="text-muted">Giám Đốc Điều Hành</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact CTA Section -->
    <div class="about-section text-center">
        <h2 class="mb-4">Liên Hệ Với Chúng Tôi</h2>
        <p class="text-muted mb-4">Chúng tôi luôn sẵn sàng lắng nghe ý kiến đóng góp của bạn</p>
        <a href="index.php?page=contact" class="btn btn-primary btn-lg px-4 py-2">Liên Hệ Ngay</a>
    </div>
</div>

<!-- Remove any JavaScript that might be causing the error -->
<script>
// This script is intentionally empty to avoid any JavaScript errors
</script> 