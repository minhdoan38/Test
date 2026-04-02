<html>
    <head>
        <link rel="stylesheet" href="nav.css">
    </head>
    <body>
        <div>
    <nav class="navbar navbar-expand-lg navbar-floating">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fa-solid fa-leaf me-2"></i>HapVN
        </a>
        <div class="search-box">
                    <input type="text" placeholder="Tìm tên thuốc...">
                    <i class="fa fa-search"></i>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Sản Phẩm</a></li>
                
                <li class="nav-item"><a class="nav-link" href="#">Tin tức</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
            </ul>
            
            <div class="nav-right d-flex align-items-center">

                <div class="cart-icon position-relative me-3">
                    <i class="fa-solid fa-cart-shopping fa-lg"></i>
                    <span class="badge">0</span>
                </div>
                <div class="user-login">
                    <a href="authentication.php"><i class="fa-solid fa-circle-user text-dark fa-lg"></i></a>
                </div>
            </div>
        </div>
    </div>                

</nav>
    </div>
    </body>
    
</html>