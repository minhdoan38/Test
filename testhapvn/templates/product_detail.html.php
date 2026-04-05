<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($product['meta_description'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <title>Chi tiết sản phẩm - Nhà Thuốc HapVN</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="product_detail.css">
</head>
<body>

    <?php include 'navbar.php'; ?>
    <?php include 'contact.php'; ?>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($product['category_name'] ?? 'Sản phẩm', ENT_QUOTES, 'UTF-8'); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></li>
            </ol>
        </nav>
    </div>

    <section class="product-detail-section py-4">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-4">
                    <div class="product-gallery shadow-sm">
                        <?php if ((int) ($product['is_prescription'] ?? 0) === 1) { ?>
                            <div class="prescription-badge">
                                <i class="fa-solid fa-file-prescription me-1"></i> Thuốc kê đơn
                            </div>
                        <?php } ?>

                        <img src="uploads/<?php echo htmlspecialchars($product['image_url'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                             onerror="this.src='https://via.placeholder.com/500x500'"
                             alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>"
                             class="main-img img-fluid">
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="product-info">
                        <h1 class="product-name"><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
                        <div class="d-flex align-items-center mb-3">
                            <span class="text-muted small me-3">Mã SP: <?php echo (int) $product['product_id']; ?></span>
                            <span class="text-warning small">
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                (<?php echo count($comments); ?> đánh giá thực tế)
                            </span>
                        </div>

                        <div class="price-box mb-3">
                            <span class="current-price"><?php echo number_format((float) $product['price'], 0, '', '.'); ?>đ</span>
                            <span class="unit-text">/ <?php echo htmlspecialchars($product['unit'] ?? 'Sản phẩm', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>

                        <p class="short-desc">
                            <?php echo htmlspecialchars($product['meta_description'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                        </p>

                        <div class="policy-box mb-4">
                            <div class="policy-item"><i class="fa-solid fa-check-circle text-success"></i> 100% Chính hãng</div>
                            <div class="policy-item"><i class="fa-solid fa-truck-fast text-primary"></i> Giao nhanh 2h</div>
                            <div class="policy-item"><i class="fa-solid fa-rotate-left text-warning"></i> Đổi trả 7 ngày</div>
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
                    <div class="p-4 bg-white border rounded shadow-sm">
                        <h5>Mô tả sản phẩm</h5>
                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($product['description'] ?? '', ENT_QUOTES, 'UTF-8')); ?></p>
                    </div>
                </div>
            </div>

            <div class="row mt-4" id="reviews">
                <div class="col-12">
                    <div class="p-4 bg-white border rounded shadow-sm">
                        <h5 class="mb-3">Đánh giá thực tế từ khách hàng</h5>

                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <form action="product_detail.php?id=<?php echo (int) $product['product_id']; ?>#reviews" method="POST" enctype="multipart/form-data" class="comment-form mb-4">
                                <input type="hidden" name="action" value="add_comment">
                                <div class="mb-2">
                                    <label class="form-label">Nội dung bình luận (<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>)</label>
                                    <textarea class="form-control" name="content" rows="3" required placeholder="Chia sẻ trải nghiệm thực tế..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Đính kèm ảnh/video</label>
                                    <input type="file" class="form-control" name="media" accept="image/*,video/*">
                                </div>
                                <button class="btn btn-success" type="submit"><i class="fa-solid fa-paper-plane me-1"></i>Gửi bình luận</button>
                            </form>
                        <?php } else { ?>
                            <div class="alert alert-warning">Vui lòng <a href="authentication.php">đăng nhập</a> để bình luận và phản hồi.</div>
                        <?php } ?>

                        <?php if (empty($comments)) { ?>
                            <p class="text-muted">Chưa có bình luận nào cho sản phẩm này.</p>
                        <?php } ?>

                        <?php foreach ($comments as $comment) { ?>
                            <div class="comment-item <?php echo (int) $comment['is_pinned'] === 1 ? 'pinned-comment' : ''; ?>">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong><?php echo htmlspecialchars($comment['customer_name'] ?: 'Khách hàng', ENT_QUOTES, 'UTF-8'); ?></strong>
                                        <?php if ((int) $comment['is_pinned'] === 1) { ?>
                                            <span class="badge bg-warning text-dark ms-2"><i class="fa-solid fa-thumbtack"></i> Ghim</span>
                                        <?php } ?>
                                        <div class="text-muted small"><?php echo htmlspecialchars($comment['created_at'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    </div>
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                                        <form method="POST" action="product_detail.php?id=<?php echo (int) $product['product_id']; ?>#reviews">
                                            <input type="hidden" name="action" value="pin_comment">
                                            <input type="hidden" name="comment_id" value="<?php echo (int) $comment['comment_id']; ?>">
                                            <button class="btn btn-sm btn-outline-secondary" type="submit">Ghim/Bỏ ghim</button>
                                        </form>
                                    <?php } ?>
                                </div>

                                <p class="mt-2 mb-2"><?php echo nl2br(htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8')); ?></p>

                                <?php if (!empty($comment['media_path'])) { ?>
                                    <div class="comment-media mb-2">
                                        <?php if ($comment['media_type'] === 'image') { ?>
                                            <img src="<?php echo htmlspecialchars($comment['media_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="media comment" class="img-fluid rounded">
                                        <?php } elseif ($comment['media_type'] === 'video') { ?>
                                            <video controls class="w-100 rounded">
                                                <source src="<?php echo htmlspecialchars($comment['media_path'], ENT_QUOTES, 'UTF-8'); ?>">
                                            </video>
                                        <?php } ?>
                                    </div>
                                <?php } ?>

                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <details>
                                        <summary class="reply-toggle">Trả lời bình luận</summary>
                                        <form action="product_detail.php?id=<?php echo (int) $product['product_id']; ?>#reviews" method="POST" enctype="multipart/form-data" class="mt-2">
                                            <input type="hidden" name="action" value="add_reply">
                                            <input type="hidden" name="parent_comment_id" value="<?php echo (int) $comment['comment_id']; ?>">
                                            <div class="mb-2">
                                                <textarea class="form-control form-control-sm" name="content" rows="2" required placeholder="Nhập nội dung phản hồi..."></textarea>
                                            </div>
                                            <div class="mb-2">
                                                <input type="file" class="form-control form-control-sm" name="media" accept="image/*,video/*">
                                            </div>
                                            <button class="btn btn-sm btn-outline-success" type="submit">Gửi phản hồi</button>
                                        </form>
                                    </details>
                                <?php } ?>

                                <?php if (!empty($repliesByComment[$comment['comment_id']])) { ?>
                                    <div class="replies mt-3">
                                        <?php foreach ($repliesByComment[$comment['comment_id']] as $reply) { ?>
                                            <div class="reply-item">
                                                <strong><?php echo htmlspecialchars($reply['customer_name'] ?: 'Khách hàng', ENT_QUOTES, 'UTF-8'); ?></strong>
                                                <div class="text-muted small"><?php echo htmlspecialchars($reply['created_at'], ENT_QUOTES, 'UTF-8'); ?></div>
                                                <p class="mb-1"><?php echo nl2br(htmlspecialchars($reply['content'], ENT_QUOTES, 'UTF-8')); ?></p>

                                                <?php if (!empty($reply['media_path'])) { ?>
                                                    <?php if ($reply['media_type'] === 'image') { ?>
                                                        <img src="<?php echo htmlspecialchars($reply['media_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="reply media" class="img-fluid rounded reply-media">
                                                    <?php } elseif ($reply['media_type'] === 'video') { ?>
                                                        <video controls class="w-100 rounded reply-media">
                                                            <source src="<?php echo htmlspecialchars($reply['media_path'], ENT_QUOTES, 'UTF-8'); ?>">
                                                        </video>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="related-products mt-5">
                <h4 class="fw-bold mb-4">Sản phẩm dành riêng cho bạn</h4>
                <p class="text-muted">Gợi ý từ lịch sử xem sản phẩm của bạn.</p>
                <div class="row g-4">
                    <?php foreach ($recommendedProducts as $item) { ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="product-card h-100">
                                <div class="product-img-container recommended-image-box">
                                    <img src="uploads/<?php echo htmlspecialchars($item['image_url'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                         onerror="this.src='https://via.placeholder.com/200'"
                                         class="img-fluid recommended-image"
                                         alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="product-body">
                                    <span class="product-category"><?php echo htmlspecialchars($item['category_name'] ?? 'Sản phẩm', ENT_QUOTES, 'UTF-8'); ?></span>
                                    <a href="product_detail.php?id=<?php echo (int) $item['product_id']; ?>" class="product-title d-block"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></a>
                                    <p class="product-price"><?php echo number_format((float) $item['price'], 0, '.', ','); ?>đ</p>
                                    <a href="product_detail.php?id=<?php echo (int) $item['product_id']; ?>" class="btn btn-outline-success w-100">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
