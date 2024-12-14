<?php
session_start();
if ($_SESSION['role'] != 1) {
    // Chỉ Admin mới có quyền truy cập
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "GTPT");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash mật khẩu
    $role = $_POST['role'];
    $phone = $_POST['phone'];

    // Xử lý upload ảnh đại diện
    $target_dir = "uploads/avatars/";
    $avatar = $_FILES['avatar']['name'];
    $target_file = $target_dir . basename($avatar);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file);

    // Thêm tài khoản người dùng vào cơ sở dữ liệu
    $query = "INSERT INTO USER (Name, Username, Email, Password, Role, Phone, Avatar) 
              VALUES ('$name', '$username', '$email', '$password', $role, '$phone', '$target_file')";
    if ($conn->query($query)) {
        echo "Thêm tài khoản người dùng thành công!";
    } else {
        echo "Có lỗi xảy ra: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tài khoản người dùng</title>
    <!-- Thêm Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 50px auto;
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }
        .form-container button {
            background-color: #28a745;
            color: white;
        }
        .form-container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Thêm tài khoản người dùng mới</h1>
            <form action="add_user.php" method="POST" enctype="multipart/form-data">
                <!-- Họ tên -->
                <div class="mb-3">
                    <label for="name" class="form-label">Họ tên:</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <!-- Tên đăng nhập -->
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập:</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <!-- Mật khẩu -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <!-- Quyền -->
                <div class="mb-3">
                    <label for="role" class="form-label">Quyền:</label>
                    <select class="form-select" name="role" required>
                        <option value="0">Người dùng</option>
                        <option value="1">Quản trị viên</option>
                    </select>
                </div>

                <!-- Số điện thoại -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại:</label>
                    <input type="text" class="form-control" name="phone" required>
                </div>

                <!-- Ảnh đại diện -->
                <div class="mb-3">
                    <label for="avatar" class="form-label">Ảnh đại diện:</label>
                    <input type="file" class="form-control" name="avatar">
                </div>

                <!-- Nút submit -->
                <button type="submit" class="btn btn-success w-100">Thêm tài khoản</button>
            </form>
        </div>
    </div>

    <!-- Thêm Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
