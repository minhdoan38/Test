<?php
    try {
        include 'includes/databaseconnection.php';
        $sql = "SELECT * FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM categories";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categoryMap = array_column($categories, 'name', 'category_id');

        $products = array_map(function($product) use ($categoryMap) {
            return array_merge($product, [
                'category_name' => $categoryMap[$product['category_id']]
            ]);
        }, $products);


    } catch (PDOException $e) {
        echo 'Failed to retrieve products: ' . $e->getMessage();
    }
?>