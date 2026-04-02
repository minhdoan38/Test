<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm: <?php echo $product['name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 900px;">
    
    <?php if(isset($message) && $message == 'success'): ?>
        <div class="alert alert-success">Cập nhật sản phẩm thành công! <a href="admin.php">Quay lại danh sách</a></div>
    <?php elseif(isset($message) && $message == 'error'): ?>
        <div class="alert alert-danger">Có lỗi xảy ra, vui lòng thử lại.</div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center">
            <span>CHỈNH SỬA: <?php echo $product['name']; ?></span>
            <a href="admin.php" class="btn btn-sm btn-dark">Quay lại</a>
        </div>
        <div class="card-body">
            
            <form action="" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="old_image" value="<?php echo $product['image_url']; ?>">

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên thuốc:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $product['name']; ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Danh mục:</label>
                                <select name="category_id" class="form-select">
                                    <option value="1" <?php if($product['category_id'] == 1) echo 'selected'; ?>>Thuốc điều trị</option>
                                    <option value="2" <?php if($product['category_id'] == 2) echo 'selected'; ?>>Thực phẩm chức năng</option>
                                    <option value="3" <?php if($product['category_id'] == 3) echo 'selected'; ?>>Dụng cụ y tế</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Đơn vị tính:</label>
                                <select name="unit" class="form-select">
                                    <option value="Hộp" <?php if($product['unit'] == 'Hộp') echo 'selected'; ?>>Hộp</option>
                                    <option value="Vỉ" <?php if($product['unit'] == 'Vỉ') echo 'selected'; ?>>Vỉ</option>
                                    <option value="Chai" <?php if($product['unit'] == 'Chai') echo 'selected'; ?>>Chai/Lọ</option>
                                    <option value="Cái" <?php if($product['unit'] == 'Cái') echo 'selected'; ?>>Cái</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá bán:</label>
                                <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tồn kho:</label>
                                <input type="number" name="stock" class="form-control" value="<?php echo $product['stock_quantity']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả:</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo $product['description']; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Hình ảnh:</label>
                            <div class="mb-2 text-center border rounded p-2 bg-white">
                                <img id="preview" src="uploads/<?php echo $product['image_url']; ?>" 
                                     onerror="this.src='https://via.placeholder.com/150'"
                                     style="max-width: 100%; height: 150px; object-fit: contain;">
                            </div>
                            <input type="file" name="product_image" class="form-control" onchange="previewImage(this)">
                        </div>

                        <div class="mb-3 border p-3 rounded bg-white">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_prescription" value="1" id="rxCheck" 
                                    <?php if($product['is_prescription'] == 1) echo 'checked'; ?>>
                                <label class="form-check-label fw-bold text-danger" for="rxCheck">Thuốc kê đơn (RX)</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="btn_update" class="btn btn-primary fw-bold">LƯU CẬP NHẬT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>