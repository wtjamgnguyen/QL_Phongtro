<?php
session_start();

// Kiểm tra xem người dùng có phải là Admin không
if ($_SESSION['role'] != 1) {
    // Chỉ Admin mới có quyền truy cập
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "GTPT");

// Kiểm tra xem tham số 'id' đã được truyền chưa và có phải là số không
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID không hợp lệ.");
}

$id = $_GET['id'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$query = "SELECT * FROM USER WHERE ID = $id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Kiểm tra xem người dùng có tồn tại không
if (!$user) {
    die("Người dùng không tồn tại.");
}

// Tiến hành cập nhật nếu có yêu cầu từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    // Nếu người dùng thay đổi mật khẩu
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash mật khẩu mới
        $update_query = "UPDATE USER SET Name='$name', Username='$username', Email='$email', Phone='$phone', Role=$role, Password='$password' WHERE ID=$id";
    } else {
        $update_query = "UPDATE USER SET Name='$name', Username='$username', Email='$email', Phone='$phone', Role=$role WHERE ID=$id";
    }

    // Xử lý upload ảnh đại diện mới (nếu có)
    if ($_FILES['avatar']['name']) {
        $target_dir = "uploads/avatars/";
        $avatar = $_FILES['avatar']['name'];
        $target_file = $target_dir . basename($avatar);
        move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file);
        $update_query = "UPDATE USER SET Avatar='$target_file' WHERE ID=$id";
    }

    // Cập nhật thông tin vào cơ sở dữ liệu
    if ($conn->query($update_query)) {
        echo "Cập nhật tài khoản thành công!";
    } else {
        echo "Có lỗi xảy ra: " . $conn->error;
    }
}

// Xóa tài khoản
if (isset($_POST['delete'])) {
    $delete_query = "DELETE FROM USER WHERE ID=$id";
    if ($conn->query($delete_query)) {
        echo "Xóa tài khoản thành công!";
        header("Location: manage_users.php"); // Quay lại trang quản lý người dùng
    } else {
        echo "Có lỗi xảy ra khi xóa: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật người dùng</title>
</head>
<body>
    <h1>Cập nhật thông tin người dùng</h1>

    <form action="admin_update_user.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Họ tên:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required><br>

        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['Phone']); ?>" required><br>

        <label for="role">Quyền:</label>
        <select name="role" required>
            <option value="1" <?php echo ($user['Role'] == 1) ? 'selected' : ''; ?>>Admin</option>
            <option value="2" <?php echo ($user['Role'] == 2) ? 'selected' : ''; ?>>Người dùng</option>
        </select><br>

        <label for="password">Mật khẩu mới:</label>
        <input type="password" name="password"><br>

        <label for="avatar">Ảnh đại diện:</label>
        <input type="file" name="avatar"><br>

        <input type="submit" value="Cập nhật">
    </form>

    <form action="admin_update_user.php?id=<?php echo $id; ?>" method="POST">
        <input type="submit" name="delete" value="Xóa tài khoản" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này không?')">
    </form>
</body>
</html>
