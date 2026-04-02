<?php
include 'includes/databaseconnection.php';

$product_id = $_GET['id'];

$sql = "SELECT * FROM products WHERE product_id = :product_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':product_id', $product_id);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? $product['slug'];
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $unit = $_POST['unit'] ?? '';
    $description = $_POST['description'] ?? '';
    $image_url = $_POST['image_url'] ?? $product['image_url'];
    $is_prescription = isset($_POST['is_prescription']) ? $_POST['is_prescription'] : 0;
    $meta_title = $_POST['meta_title'] ?? '';
    $meta_desc = $_POST['meta_desc'] ?? '';

    $sql = "UPDATE products SET
                category_id = :category_id,
                name = :name,
                slug = :slug,
                price = :price,
                stock_quantity = :stock,
                unit = :unit,
                description = :description,
                image_url = :image_url,
                is_prescription = :is_prescription,
                meta_title = :meta_title,
                meta_description = :meta_desc
            WHERE product_id = :product_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':slug', $slug);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':unit', $unit);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':is_prescription', $is_prescription);
    $stmt->bindParam(':meta_title', $meta_title);
    $stmt->bindParam(':meta_desc', $meta_desc);
    $stmt->bindParam(':product_id', $product_id);

    if ($stmt->execute()) {
        header('Location: admin.php');
        exit();
    } else {
        include 'templates/editproduct.html.php';
        echo "<script>alert('Lỗi: " . $stmt->errorInfo()[2] . "');</script>";
    }
} else {
    include 'templates/editproduct.html.php';
}

?>

