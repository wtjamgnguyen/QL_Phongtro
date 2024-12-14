<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa và có quyền Admin không
if (!isset($_SESSION['username']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <!-- Thêm thanh điều hướng (navbar) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <a class="navbar-brand" href="#">Quản lý Admin</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="motel_list.php">Danh sách Phòng trọ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>

    <h1 class="my-4 text-center">Trang Quản trị Admin</h1>

    <!-- Khu vực chức năng admin -->
    <div class="row">
        <!-- Nút Thêm Phòng Trọ -->
        <div class="col-md-6 mb-4">
            <a href="admin_add_motel.php" class="btn btn-primary btn-block p-4">
                <h3>Thêm Phòng Trọ</h3>
            </a>
        </div>

        <!-- Nút Thêm Người Dùng -->
        <div class="col-md-6 mb-4">
            <a href="admin_add_user.php" class="btn btn-success btn-block p-4">
                <h3>Thêm Người Dùng</h3>
            </a>
        </div>

        <!-- Nút Cập Nhật Phòng Trọ -->
        <div class="col-md-6 mb-4">
            <a href="admin_update_motel.php" class="btn btn-warning btn-block p-4">
                <h3>Cập Nhật Phòng Trọ</h3>
            </a>
        </div>

        <!-- Nút Cập Nhật Người Dùng -->
        <div class="col-md-6 mb-4">
            <a href="admin_update_user.php" class="btn btn-danger btn-block p-4">
                <h3>Cập Nhật Người Dùng</h3>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
