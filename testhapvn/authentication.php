<?php
session_start();

include 'includes/databaseconnection.php';

function isSafeReturnPath(?string $target): bool
{
    if ($target === null || $target === '') {
        return false;
    }

    $parts = parse_url($target);
    if ($parts === false) {
        return false;
    }

    if (!empty($parts['scheme']) || !empty($parts['host'])) {
        return false;
    }

    $path = $parts['path'] ?? '';
    if ($path === '' || $path[0] !== '/') {
        return false;
    }

    return true;
}

function normalizeReturnPath(?string $target): string
{
    if (!isSafeReturnPath($target)) {
        return '/index.php';
    }

    return $target;
}

$infoMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $incomingReturn = $_GET['return_to'] ?? null;
    if ($incomingReturn !== null && isSafeReturnPath($incomingReturn)) {
        $_SESSION['return_to_after_login'] = $incomingReturn;
    }
}

$returnTo = normalizeReturnPath($_SESSION['return_to_after_login'] ?? '/index.php');

if (isset($_GET['social'])) {
    $provider = strtolower((string) $_GET['social']);
    if (in_array($provider, ['google', 'facebook'], true)) {
        $infoMessage = 'Tạm thời chưa hỗ trợ đăng nhập bằng Google/Facebook. Vui lòng dùng tài khoản HapVN.';
    }
}

if (isset($_SESSION['user_id'])) {
    $redirectUrl = $returnTo;

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && $redirectUrl === '/index.php') {
        $redirectUrl = '/admin.php';
    }

    unset($_SESSION['return_to_after_login']);
    header('Location: ' . ltrim($redirectUrl, '/'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    try {
        $sql = 'SELECT * FROM users WHERE username = :username AND password = :password';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $password,
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            $redirectUrl = normalizeReturnPath($_SESSION['return_to_after_login'] ?? '/index.php');
            if ($user['role'] === 'admin' && $redirectUrl === '/index.php') {
                $redirectUrl = '/admin.php';
            }

            unset($_SESSION['return_to_after_login']);
            header('Location: ' . ltrim($redirectUrl, '/'));
            exit;
        }

        $infoMessage = 'Sai tài khoản hoặc mật khẩu.';
    } catch (PDOException $e) {
        $infoMessage = 'Không thể đăng nhập lúc này. Vui lòng thử lại.';
    }
}

include 'templates/login.html.php';
?>
