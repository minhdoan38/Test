<?php
// 1. Khởi động session
session_start();

// 2. Kết nối database
include 'includes/databaseconnection.php';

if (isset($_GET['social'])) {
    $provider = strtolower($_GET['social']);
    if (in_array($provider, ['google', 'facebook'], true)) {
        $socialUsername = $provider . '_user';
        $socialFullName = $provider === 'google' ? 'Người dùng Google' : 'Người dùng Facebook';

        $findSql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $findStmt = $pdo->prepare($findSql);
        $findStmt->execute([':username' => $socialUsername]);
        $user = $findStmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $insertSql = "INSERT INTO users (username, password, full_name, role) VALUES (:username, :password, :full_name, 'customer')";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->execute([
                ':username' => $socialUsername,
                ':password' => bin2hex(random_bytes(8)),
                ':full_name' => $socialFullName,
            ]);

            $findStmt->execute([':username' => $socialUsername]);
            $user = $findStmt->fetch(PDO::FETCH_ASSOC);
        }

        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
            exit();
        }
    }
}

// --- PHẦN 1: KIỂM TRA NẾU ĐÃ ĐĂNG NHẬP TRƯỚC ĐÓ ---
if (isset($_SESSION['user_id'])) {
    // Kiểm tra quyền ngay lập tức
    if ($_SESSION['role'] == 'admin') {
        header('Location: admin.php');
    } else {
        header('Location: index.php');
    }
    exit();
}

// --- PHẦN 2: XỬ LÝ KHI BẤM NÚT ĐĂNG NHẬP ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Lưu session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Cột này trong DB phải là 'admin' hoặc 'user'

            // --- LOGIC ĐIỀU HƯỚNG QUAN TRỌNG ---
            if ($user['role'] == 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }
            exit();
            
        } else {
            echo "<script>alert('Sai tài khoản hoặc mật khẩu');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
    }
}

include 'templates/login.html.php';
?>
