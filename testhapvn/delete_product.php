<?php
    include 'includes/databaseconnection.php';

    $product_id = $_GET['id'];

    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();

    header('Location: admin.php');
    exit();
?>