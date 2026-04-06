<?php
try {
    include 'includes/databaseconnection.php';

    $sql = "SELECT p.*, COALESCE(c.name, 'Chưa phân loại') AS category_name
            FROM products p
            LEFT JOIN categories c ON c.category_id = p.category_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Failed to retrieve products: ' . $e->getMessage();
}
?>
