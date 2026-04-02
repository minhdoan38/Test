<?php
// 1. Kết nối Database
require_once 'includes/databaseconnection.php ';

// 2. Kiểm tra nút bấm
if (isset($_POST['btn_save'])) {
    
    // --- Lấy dữ liệu từ Form ---
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    
    // SEO Data
    $meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : $name;
    // Lấy meta_description từ form. Nếu trống thì cắt 150 ký tự đầu của mô tả chính
    $meta_desc = !empty($_POST['meta_description']) ? $_POST['meta_description'] : substr(strip_tags($description), 0, 150);
    
    // Thuốc kê đơn (Checkbox)
    $is_prescription = isset($_POST['is_prescription']) ? 1 : 0;

    // Tạo Slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))) . '-' . time();

    // --- XỬ LÝ ẢNH ---
    $image_url = 'default.png'; 
    
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $target_dir = "uploads/";
        $new_filename = time() . '_' . basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $new_filename;
        
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image_url = $new_filename;
        }
    }

    // --- CÂU LỆNH INSERT (Đã thêm meta_description) ---
    $sql = "INSERT INTO products (
                category_id, name, slug, price, stock_quantity, unit, 
                description, image_url, is_prescription, meta_title, meta_description
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    
    // Bind param
    $stmt->bindParam(1, $category_id);
    $stmt->bindParam(2, $name);
    $stmt->bindParam(3, $slug);
    $stmt->bindParam(4, $price);
    $stmt->bindParam(5, $stock);
    $stmt->bindParam(6, $unit);
    $stmt->bindParam(7, $description);
    $stmt->bindParam(8, $image_url);
    $stmt->bindParam(9, $is_prescription);
    $stmt->bindParam(10, $meta_title);
    $stmt->bindParam(11, $meta_desc); // Biến mới thêm

    header("Location: admin.php");
    if ($stmt->execute()) {
        echo "<script>
            alert('Thêm sản phẩm thành công!');
            window.location.href = 'admin.html';
        </script>";
    } else {
        echo "Lỗi: " . $pdo->error;
    }
    
    $stmt->close();
    $pdo->close();
}
?>