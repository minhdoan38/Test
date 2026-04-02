<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập / Đăng ký - Nhà Thuốc HapVN</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="auth-container">
        
        <div class="auth-card shadow-lg">
            <div class="text-center mb-4">
                <a href="index.php">
                    <h3 class="fw-bold text-success"><i class="fa-solid fa-capsules"></i> HapVN</h3>
                    <p class="text-muted small">Chăm sóc sức khỏe gia đình bạn</p>
                </a>

            </div>

            <div class="auth-tabs mb-4">
                <button class="tab-btn active" onclick="switchForm('login')" id="tab-login">Đăng nhập</button>
                <button class="tab-btn" onclick="switchForm('register')" id="tab-register">Đăng ký</button>
            </div>

            <form id="login-form" action="authentication.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập hoặc Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Nhập username..." required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="********" required>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4 small">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ tôi</label>
                    </div>
                    <a href="#" class="text-decoration-none text-success">Quên mật khẩu?</a>
                </div>

                <button type="submit" name="btn_login" class="btn btn-primary w-100 btn-auth">Ðăng Nhập</button>
                
                <div class="text-center mt-3">
                    <span class="text-muted small">Hoặc đăng nhập với</span>
                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3"><i class="fa-brands fa-google me-1"></i> Google</button>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fa-brands fa-facebook me-1"></i> Facebook</button>
                    </div>
                </div>
            </form>

            <form id="register-form" action="register_process.php" method="POST" style="display: none;">
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Nguyễn Văn A" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập (Username)</label>
                    <input type="text" name="username" class="form-control" placeholder="Viết liền không dấu" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự" required>
                </div>
                
                <div class="form-check mb-4 small">
                    <input type="checkbox" class="form-check-input" required>
                    <label class="form-check-label">Tôi đồng ý với <a href="#" class="text-success">Điều khoản sử dụng</a></label>
                </div>

                <button type="submit" name="btn_register" class="btn btn-success w-100 btn-auth">TẠO TÀI KHOẢN</button>
            </form>

        </div>
    </div>

    <script>
        function switchForm(type) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');

            if (type === 'login') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                tabLogin.classList.add('active');
                tabRegister.classList.remove('active');
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                tabLogin.classList.remove('active');
                tabRegister.classList.add('active');
            }
        }
    </script>
</body>
</html>