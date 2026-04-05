<?php
session_start();

try {
    include 'includes/databaseconnection.php';

    $product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$product_id) {
        http_response_code(400);
        exit('Sản phẩm không hợp lệ.');
    }

    $pdo->exec("CREATE TABLE IF NOT EXISTS product_views (
        view_id INT AUTO_INCREMENT PRIMARY KEY,
        viewer_key VARCHAR(128) NOT NULL,
        user_id INT NULL,
        product_id INT NOT NULL,
        viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_viewer (viewer_key),
        INDEX idx_product (product_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS product_comments (
        comment_id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        user_id INT NULL,
        parent_comment_id INT NULL,
        customer_name VARCHAR(120) NULL,
        content TEXT NOT NULL,
        media_path VARCHAR(255) NULL,
        media_type ENUM('image','video') NULL,
        is_pinned TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_product_comment (product_id),
        INDEX idx_parent_comment (parent_comment_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $viewerKey = isset($_SESSION['user_id']) ? 'user_' . $_SESSION['user_id'] : 'guest_' . session_id();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'pin_comment' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            $commentId = filter_input(INPUT_POST, 'comment_id', FILTER_VALIDATE_INT);
            if ($commentId) {
                $sql = "UPDATE product_comments SET is_pinned = CASE WHEN is_pinned = 1 THEN 0 ELSE 1 END WHERE comment_id = :comment_id AND product_id = :product_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':comment_id' => $commentId,
                    ':product_id' => $product_id,
                ]);
            }
            header('Location: product_detail.php?id=' . $product_id . '#reviews');
            exit;
        }

        if ($action === 'add_comment' || $action === 'add_reply') {
            $content = trim($_POST['content'] ?? '');
            $customerName = trim($_POST['customer_name'] ?? '');
            $parentCommentId = $action === 'add_reply' ? filter_input(INPUT_POST, 'parent_comment_id', FILTER_VALIDATE_INT) : null;

            if ($content !== '') {
                $mediaPath = null;
                $mediaType = null;

                if (!empty($_FILES['media']['name']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mime = $finfo->file($_FILES['media']['tmp_name']);

                    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
                    $allowedVideoTypes = ['video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'];

                    if (in_array($mime, $allowedImageTypes, true) || in_array($mime, $allowedVideoTypes, true)) {
                        $mediaType = in_array($mime, $allowedImageTypes, true) ? 'image' : 'video';
                        $extension = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
                        $safeName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
                        $uploadDir = __DIR__ . '/uploads/comments';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $destination = $uploadDir . '/' . $safeName;

                        if (move_uploaded_file($_FILES['media']['tmp_name'], $destination)) {
                            $mediaPath = 'uploads/comments/' . $safeName;
                        }
                    }
                }

                if ($customerName === '') {
                    $customerName = isset($_SESSION['username']) ? $_SESSION['username'] : 'Khách hàng';
                }

                $sql = "INSERT INTO product_comments (product_id, user_id, parent_comment_id, customer_name, content, media_path, media_type)
                        VALUES (:product_id, :user_id, :parent_comment_id, :customer_name, :content, :media_path, :media_type)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':product_id' => $product_id,
                    ':user_id' => $_SESSION['user_id'] ?? null,
                    ':parent_comment_id' => $parentCommentId,
                    ':customer_name' => $customerName,
                    ':content' => $content,
                    ':media_path' => $mediaPath,
                    ':media_type' => $mediaType,
                ]);
            }

            header('Location: product_detail.php?id=' . $product_id . '#reviews');
            exit;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO product_views (viewer_key, user_id, product_id) VALUES (:viewer_key, :user_id, :product_id)");
    $stmt->execute([
        ':viewer_key' => $viewerKey,
        ':user_id' => $_SESSION['user_id'] ?? null,
        ':product_id' => $product_id,
    ]);

    $sql = "SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            WHERE p.product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        http_response_code(404);
        exit('Không tìm thấy sản phẩm.');
    }

    $sql = "SELECT *
            FROM product_comments
            WHERE product_id = :product_id AND parent_comment_id IS NULL
            ORDER BY is_pinned DESC, created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':product_id' => $product_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $commentIds = array_column($comments, 'comment_id');
    $repliesByComment = [];

    if (!empty($commentIds)) {
        $placeholders = implode(',', array_fill(0, count($commentIds), '?'));
        $replySql = "SELECT * FROM product_comments WHERE parent_comment_id IN ($placeholders) ORDER BY created_at ASC";
        $replyStmt = $pdo->prepare($replySql);
        $replyStmt->execute($commentIds);
        $replies = $replyStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($replies as $reply) {
            $repliesByComment[$reply['parent_comment_id']][] = $reply;
        }
    }

    $recommendedSql = "SELECT p.*, c.name AS category_name,
            (CASE WHEN p.category_id = :category_id THEN 2 ELSE 0 END
             + CASE WHEN viewed.product_id IS NOT NULL THEN 3 ELSE 0 END) AS score
            FROM products p
            LEFT JOIN categories c ON c.category_id = p.category_id
            LEFT JOIN (
                SELECT DISTINCT product_id
                FROM product_views
                WHERE viewer_key = :viewer_key AND product_id <> :product_id
            ) AS viewed ON viewed.product_id = p.product_id
            WHERE p.product_id <> :product_id
            ORDER BY score DESC, p.created_at DESC
            LIMIT 4";

    $recommendStmt = $pdo->prepare($recommendedSql);
    $recommendStmt->execute([
        ':category_id' => $product['category_id'],
        ':viewer_key' => $viewerKey,
        ':product_id' => $product_id,
    ]);
    $recommendedProducts = $recommendStmt->fetchAll(PDO::FETCH_ASSOC);

    include 'templates/product_detail.html.php';
} catch (PDOException $e) {
    echo 'Failed to retrieve product: ' . $e->getMessage();
}
?>
