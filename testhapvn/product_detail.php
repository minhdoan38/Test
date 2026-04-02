<?php
    try {
        include 'includes/databaseconnection.php';

        $product_id = $_GET['id'];

        $sql = "SELECT * FROM products WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        include 'templates/product_detail.html.php';
    } catch (PDOException $e) {
        echo 'Failed to retrieve product: ' . $e->getMessage();
    }
?>