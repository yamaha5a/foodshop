        <!-- Hero Start -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">Đồ Ăn Nhanh Ngon Miệng</h4>
                    <h1 class="mb-5 display-3 text-primary">Burger, Pizza & Món Ngon Khác</h1>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                        <?php
                        $first = true;
                        foreach ($banners as $banner) :
                            $imagePath = '/shopfood/admin/public/' . $banner['hinhanh'];
                        ?>
                            <div class="carousel-item <?= $first ? 'active' : ''; ?> rounded">
                                <img src="<?= $imagePath; ?>" class="img-fluid w-100 h-100 rounded" style="background: none;" alt="Slide">

                                <a href="#" class="btn px-4 py-2 text-white rounded">Xem ngay</a>
                            </div>
                        <?php
                            $first = false;
                        endforeach;
                        ?>
                                                </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>