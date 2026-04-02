<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo$product["meta_description"]?>">
    <title>Chi tiết sản phẩm - Nhà Thuốc HapVN</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="product_detail.css"> </head>
<body>

    <?php include 'navbar.php'; ?>
    <?php include 'contact.php';?>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Thuốc không kê đơn</a></li>
                <li class="breadcrumb-item active" aria-current="page">Panadol Extra</li>
            </ol>
        </nav>
    </div>

    <section class="product-detail-section py-4">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-4">
                    <div class="product-gallery shadow-sm">
                        <div class="prescription-badge">
                            <i class="fa-solid fa-file-prescription me-1"></i> Thuốc kê đơn
                        </div>
                        
                        <img src="https://via.placeholder.com/500x500" alt="Panadol Extra" class="main-img img-fluid">
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="product-info">
                        <h1 class="product-name"><?php echo$product["name"]?></h1>
                        <div class="d-flex align-items-center mb-3">
                            <span class="text-muted small me-3">Mã SP: <?php echo$product["product_id"]?></span>
                            <span class="text-warning small">
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                (<?php echo rand(1, 100); ?> đánh giá)
                            </span>
                        </div>

                        <div class="price-box mb-3">
                            <span class="current-price"><?php echo number_format($product["price"], 0, '', '.');?>đ</span>
                            <span class="unit-text">/ Hộp</span>
                        </div>

                        <p class="short-desc">
                            <?php echo$product["meta_description"]?>
                        </p>

                        <div class="policy-box mb-4">
                            <div class="policy-item"><i class="fa-solid fa-check-circle text-success"></i> 100% Chính hãng</div>
                            <div class="policy-item"><i class="fa-solid fa-truck-fast text-primary"></i> Giao nhanh 2h</div>
                            <div class="policy-item"><i class="fa-solid fa-rotate-left text-warning"></i> Đổi trả 7 ngày</div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            
                        </div>
                        
                        <div class="alert alert-info py-2 small">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            Dược sĩ tư vấn: <strong>0983139310</strong> (7:00 - 22:00)
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="description-tabs">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button">Mô tả sản phẩm</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="usage-tab" data-bs-toggle="tab" data-bs-target="#usage" type="button">Liều dùng & Cách dùng</button>
                            </li>
                        </ul>
                        <div class="tab-content p-4 bg-white border border-top-0 rounded-bottom shadow-sm" id="myTabContent">
                            <div class="tab-pane fade show active" id="desc">
                                    <h5>Mô tả</h5>
                                    <p><?php echo$product["description"]?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="related-products mt-5">
                <h4 class="fw-bold mb-4">Sản phẩm cùng loại</h4>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="product-card">
                            <div class="product-img-container">
                                <img src="https://via.placeholder.com/200" width="80%" alt="Thuốc khác">
                            </div>
                            <div class="product-body">
                                <a href="#" class="product-title">Efferalgan 500mg</a>
                                <p class="product-price">60.000đ</p>
                                <button class="btn btn-outline-success w-100">Xem chi tiết</button>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Nhà Thuốc HapVN. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>