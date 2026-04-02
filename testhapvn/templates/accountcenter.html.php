<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản - Nhà Thuốc Leli</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="account.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="account-sidebar shadow-sm">
                    <div class="user-brief d-flex align-items-center mb-4">
                        <div class="avatar-circle me-3">
                            <img src="https://i.pravatar.cc/150?img=12" alt="Avatar">
                        </div>
                        <div class="user-info">
                            <p class="mb-0 text-muted small">Tài khoản của</p>
                            <h6 class="fw-bold mb-0">Nguyễn Văn An</h6>
                        </div>
                    </div>

                    <div class="list-group list-group-flush nav-account">
                        <a href="account.php" class="list-group-item list-group-item-action active">
                            <i class="fa-regular fa-user me-3"></i> Hồ sơ cá nhân
                        </a>
                        <a href="my_orders.php" class="list-group-item list-group-item-action">
                            <i class="fa-solid fa-clipboard-list me-3"></i> Đơn mua 
                            <span class="badge bg-danger rounded-pill ms-auto">2</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fa-solid fa-location-dot me-3"></i> Sổ địa chỉ
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fa-solid fa-lock me-3"></i> Đổi mật khẩu
                        </a>
                        <a href="logout.php" class="list-group-item list-group-item-action text-danger logout-btn">
                            <i class="fa-solid fa-right-from-bracket me-3"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Hồ sơ của tôi</h5>
                        <p class="text-muted small mb-4">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
                        
                        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label text-muted">Tên đăng nhập</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control-plaintext fw-bold" value="nguyenvana" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label text-muted">Họ và tên</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="full_name" value="Nguyễn Văn An">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label text-muted">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email" value="an.nguyen@gmail.com">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label text-muted">Số điện thoại</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="phone" value="0988 123 456">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label text-muted">Địa chỉ</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="address" rows="2">123 Đường Láng, Đống Đa, Hà Nội</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit" class="btn btn-save-profile px-4">Lưu thay đổi</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 d-flex flex-column align-items-center justify-content-center border-start">
                                    <div class="avatar-upload-box mb-3">
                                        <img src="https://i.pravatar.cc/150?img=12" alt="Avatar Preview" id="avatarPreview">
                                    </div>
                                    <label class="btn btn-outline-secondary btn-sm">
                                        <i class="fa-solid fa-camera me-2"></i>Chọn ảnh
                                        <input type="file" hidden onchange="previewImage(this)">
                                    </label>
                                    <p class="text-muted small mt-3 text-center">
                                        Dụng lượng file tối đa 1 MB<br>Định dạng: .JPEG, .PNG
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">Đơn hàng gần đây</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Sản phẩm</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#DH001</td>
                                        <td>10/01/2026</td>
                                        <td>Panadol Extra, Vitamin C...</td>
                                        <td class="fw-bold text-primary">265.000đ</td>
                                        <td><span class="badge bg-success">Đã giao</span></td>
                                        <td><a href="#" class="btn btn-sm btn-outline-primary">Xem</a></td>
                                    </tr>
                                    <tr>
                                        <td>#DH002</td>
                                        <td>11/01/2026</td>
                                        <td>Máy đo huyết áp Omron</td>
                                        <td class="fw-bold text-primary">890.000đ</td>
                                        <td><span class="badge bg-warning text-dark">Đang xử lý</span></td>
                                        <td><a href="#" class="btn btn-sm btn-outline-primary">Xem</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>