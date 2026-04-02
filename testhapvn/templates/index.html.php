<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HapVN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    
    <style>
        .active-link {
            color: #0d6efd !important;
            font-weight: bold;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<?php include 'contact.php';?>
<?php include 'navbar.php'; ?>
<?php include 'products.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-3">
            <div class="filter-section mb-4">
                <h6 class="filter-title text-primary"><i class="fa-solid fa-filter me-2"></i>Danh mục</h6>
                
                <div class="list-group list-group-flush" id="categoryList">
                    <a href="javascript:void(0)" onclick="filterSmart('all', this)" class="list-group-item list-group-item-action border-0 px-0 active-link">
                        Tất cả sản phẩm
                    </a>
                    
                    <a href="javascript:void(0)" onclick="filterSmart('rx', this)" class="list-group-item list-group-item-action border-0 px-0">
                        <i class="fa-solid fa-prescription text-danger me-2"></i>Thuốc kê đơn
                    </a>
                    <a href="javascript:void(0)" onclick="filterSmart('otc', this)" class="list-group-item list-group-item-action border-0 px-0">
                        <i class="fa-solid fa-pills text-success me-2"></i>Thuốc không kê đơn
                    </a>

                    <a href="javascript:void(0)" onclick="filterSmart('Thực phẩm chức năng', this)" class="list-group-item list-group-item-action border-0 px-0">
                        Thực phẩm chức năng
                    </a>
                    <a href="javascript:void(0)" onclick="filterSmart('Dụng cụ y tế', this)" class="list-group-item list-group-item-action border-0 px-0">
                        Dụng cụ y tế
                    </a>
                </div>

                
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0">Sản phẩm nổi bật</h4>
                <select class="form-select w-auto" id="sortSelect">
                    <option value="newest">Mới nhất</option>
                    <option value="low-to-high">Giá thấp đến cao</option>
                    <option value="high-to-low">Giá cao đến thấp</option>
                </select>
            </div>

            <div class="row" id="productList">
                <?php foreach ($products as $product) { ?>
                    
                    <div class="col-md-4 mb-4 product-item" 
                         data-price="<?php echo $product['price']; ?>" 
                         data-id="<?php echo $product['product_id']; ?>"
                         data-category="<?php echo $product['category_name']; ?>"
                         data-prescription="<?php echo $product['is_prescription']; ?>"> <div class="product-card">
                            <a href="product_detail.php?id=<?php echo $product['product_id']; ?>">
                                <div class="product-img-container position-relative">
                                    
                                    <?php if ($product['is_prescription'] == 1) { ?>
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">RX</span>
                                    <?php } ?>

                                    <?php if ($product['stock_quantity'] == 0) { ?>
                                        <span class="out-of-stock">Hết hàng</span>
                                    <?php } ?>
                                    <img src="uploads/<?php echo $product['image_url']; ?>" class="product-img-container" onerror="this.src='https://via.placeholder.com/50'">
                                </div>
                                <div class="product-body">
                                    <span class="product-category"><?php echo $product['category_name']; ?></span>
                                    <h5 class="product-title"><?php echo $product['name']; ?></h5>
                                    <p class="product-price"><?php echo number_format($product['price'], 0, '.', ','); ?>đ / <?php echo $product['unit']; ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            
            <div id="no-products" class="text-center mt-5" style="display: none;">
                <p class="text-muted">Không có sản phẩm nào thuộc mục này.</p>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p>&copy; 2024 Nhà Thuốc HapVN.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function filterSmart(filterType, element) {
        // 1. Highlight mục đang chọn
        const links = document.querySelectorAll('#categoryList a');
        links.forEach(link => link.classList.remove('active-link'));
        element.classList.add('active-link');

        // 2. Lấy danh sách sản phẩm
        const items = document.getElementsByClassName('product-item');
        let visibleCount = 0;

        for (let i = 0; i < items.length; i++) {
            const itemCat = items[i].getAttribute('data-category'); // Tên danh mục (vd: Thực phẩm chức năng)
            const itemRx  = items[i].getAttribute('data-prescription'); // 1 hoặc 0

            let show = false;

            // --- LOGIC LỌC TẠI ĐÂY ---
            if (filterType === 'all') {
                show = true;
            } 
            else if (filterType === 'rx') {
                // Nếu chọn "Thuốc kê đơn": Chỉ hiện is_prescription = 1
                if (itemRx === '1') show = true;
            }
            else if (filterType === 'otc') {
                // Nếu chọn "Thuốc không kê đơn": is_prescription = 0 VÀ Danh mục phải chứa chữ "Thuốc"
                if (itemRx === '0' && itemCat.includes('Thuốc')) show = true;
            }
            else {
                // Nếu chọn TPCN hoặc Dụng cụ y tế (So sánh tên danh mục)
                if (itemCat === filterType) show = true;
            }

            // Ẩn/Hiện
            if (show) {
                items[i].style.display = 'block';
                visibleCount++;
            } else {
                items[i].style.display = 'none';
            }
        }
        
        // Hiện thông báo nếu trống
        document.getElementById('no-products').style.display = (visibleCount === 0) ? 'block' : 'none';
    }

    // (Giữ nguyên phần Sort giá ở đây...)
    document.getElementById('sortSelect').addEventListener('change', function() {
        const sortValue = this.value;
        const container = document.getElementById('productList');
        const products = Array.from(container.getElementsByClassName('product-item'));

        products.sort(function(a, b) {
            const priceA = parseFloat(a.getAttribute('data-price'));
            const priceB = parseFloat(b.getAttribute('data-price'));
            if (sortValue === 'low-to-high') return priceA - priceB;
            if (sortValue === 'high-to-low') return priceB - priceA;
            return 0;
        });

        container.innerHTML = '';
        products.forEach(p => container.appendChild(p));
    });
</script>

</body>
</html>