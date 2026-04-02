<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Nhà Thuốc HapVN</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php include 'products.php'; ?>
    <nav class="sidebar">
        <a href="#" class="sidebar-brand">
            <i class="fa-solid fa-user-shield me-2"></i> HapVN ADMIN
        </a>
        <ul class="sidebar-menu">
            <li><a href="#"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="#" class="active" onclick="switchTab('list')"><i class="fa-solid fa-box-open"></i> Quản lý sản phẩm</a></li>
            <li><a href="#" onclick="switchTab('add')"><i class="fa-solid fa-plus-circle"></i> Đăng sản phẩm</a></li>
            <li><a href="#"><i class="fa-solid fa-clipboard-list"></i> Đơn hàng</a></li>
            <li><a href="#"><i class="fa-solid fa-users"></i> Khách hàng</a></li>
            <li class="mt-5"><a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Sản phẩm</h4>
            <div class="user-profile d-flex align-items-center gap-2 bg-white px-3 py-2 rounded shadow-sm">
                <img src="https://ui-avatars.com/api/?name=Admin+Leli&background=00b894&color=fff" class="rounded-circle" width="32">
                <span class="fw-bold small">Dược Sĩ HapVN</span>
            </div>
        </div>

        <div id="product-list-view">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Tất cả sản phẩm</h5>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Tìm tên thuốc..." style="width: 200px;">
                        <button class="btn btn-primary btn-sm" onclick="switchTab('add')"><i class="fa fa-plus me-1"></i> Thêm mới</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th width="80">Ảnh</th>
                                    <th>Tên thuốc</th>
                                    <th>Danh mục</th>
                                    <th>Giá bán</th>
                                    <th>Kho</th>
                                    <th>Trạng thái</th>
                                    <th class="text-end">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product) { ?>
                                <tr>
                                    <td><?php echo $product['product_id']; ?></td>
                                    <td><img src="uploads/<?php echo $product['image_url']; ?>" class="product-img-thumb" onerror="this.src='https://via.placeholder.com/50'"></td>
                                    <td>
                                        <div class="fw-bold"><?php echo $product['name']; ?></div>
                                        <small class="text-muted">ID: <?php echo $product['product_id']; ?></small>
                                    </td>
                                    <td><?php echo $product['category_name']; ?></td>
                                    <td class="fw-bold text-primary"><?php echo number_format($product['price'], 0, '.', ','); ?>đ</td>
                                    <td><?php echo $product['stock_quantity']; ?></td>
                                    <td><span class="badge <?php if ($product['stock_quantity'] > 0) { echo 'bg-success bg-opacity-10 text-success'; } else { echo 'bg-warning bg-opacity-10 text-warning'; } ?> px-3"><?php if ($product['stock_quantity'] > 0) { echo 'Còn hàng'; } else { echo 'Sắp hết'; } ?></span></td>
                                    <td class="text-end">
                                        <a href="editproduct.php?id=<?php echo $product['product_id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-pen"></i></a>
                                        <a href="delete_product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <nav>
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div id="product-add-view" style="display: none;">
    <form action="save_product.php" method="POST" enctype="multipart/form-data">
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">Thông tin chung</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="Ví dụ: Panadol Extra">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Danh mục</label>
                                <select name="category_id" class="form-select">
                                    <option value="1">Thuốc điều trị</option>
                                    <option value="2">Thực phẩm chức năng</option>
                                    <option value="3">Dụng cụ y tế</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Đơn vị tính</label>
                                <select name="unit" class="form-select">
                                    <option value="Hộp">Hộp</option>
                                    <option value="Vỉ">Vỉ</option>
                                    <option value="Chai">Chai/Lọ</option>
                                    <option value="Cái">Cái</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá bán (VNĐ)</label>
                                <input type="number" name="price" class="form-control" required placeholder="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số lượng kho</label>
                                <input type="number" name="stock" class="form-control" value="100">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Công dụng, liều dùng..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">Tối ưu SEO</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Meta Title (Tiêu đề Google)</label>
                            <input type="text" name="meta_title" class="form-control" placeholder="Để trống sẽ tự lấy tên thuốc">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description (Mô tả tìm kiếm)</label>
                            <textarea name="meta_description" class="form-control" rows="2" placeholder="Mô tả ngắn hiển thị trên Google (khoảng 150-160 ký tự)"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">Hình ảnh đại diện</h5>
                    </div>
                    <div class="card-body">
                        <div class="image-preview-box mb-3">
                            <img id="preview-img" src="#" style="display:none; width:100%; height:100%; object-fit:contain;">
                            <i id="preview-icon" class="fa-regular fa-image fs-1"></i>
                        </div>
                        <input type="file" name="product_image" class="form-control mb-2" accept="image/*" onchange="previewFile(this)">
                        <small class="text-muted">Định dạng: JPG, PNG.</small>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">Phân loại</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_prescription" value="1" id="rxCheck">
                            <label class="form-check-label fw-bold text-danger" for="rxCheck">Thuốc kê đơn (RX)</label>
                        </div>
                        <hr>
                        <div class="d-grid gap-2">
                            <button type="submit" name="btn_save" class="btn btn-primary fw-bold" formaction="addproduct.php">LƯU SẢN PHẮM</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="switchTab('list')">Hủy bỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewFile(input) {
        var preview = document.getElementById('preview-img');
        var icon = document.getElementById('preview-icon');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
            preview.style.display = 'block';
            icon.style.display = 'none';
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>

    </div>

    <script>
        function switchTab(tabName) {
            const listView = document.getElementById('product-list-view');
            const addView = document.getElementById('product-add-view');
            const linkList = document.querySelector('a[onclick="switchTab(\'list\')"]');
            const linkAdd = document.querySelector('a[onclick="switchTab(\'add\')"]');
            
            if (tabName === 'add') {
                listView.style.display = 'none';
                addView.style.display = 'block';
                // Active class
                linkList.classList.remove('active');
                linkAdd.classList.add('active');
            } else {
                listView.style.display = 'block';
                addView.style.display = 'none';
                // Active class
                linkList.classList.add('active');
                linkAdd.classList.remove('active');
            }
        }
    </script>
</body>
</html>