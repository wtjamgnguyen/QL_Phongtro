<?php
session_start();
if ($_SESSION['role'] != 1) {
    // Chỉ Admin mới có quyền truy cập
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "GTPT");

// Lấy danh sách người dùng
$query = "SELECT * FROM USER";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <style>
        /* Tổng quan của trang */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        /* Thanh điều hướng */
        nav {
            background-color: #444;
            overflow: hidden;
        }

        nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            float: left;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Bảng người dùng */
        .container {
            width: 90%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        td a {
            color: #007BFF;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }

        /* Nút thêm người dùng */
        .add-user-btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .add-user-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Thanh điều hướng -->
    <nav>
        <a href="admin_dashboard.php">Trang chủ</a>
        <a href="manage_users.php">Quản lý người dùng</a>
        <a href="logout.php">Đăng xuất</a>
    </nav>

    <!-- Header -->
    <header>
        <h1>Quản lý người dùng</h1>
    </header>

    <!-- Nội dung trang -->
    <div class="container">
        <a href="admin_add_user.php" class="add-user-btn">Thêm người dùng mới</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Chỉnh sửa</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['ID']; ?></td>
                        <td><?php echo $user['Name']; ?></td>
                        <td><?php echo $user['Username']; ?></td>
                        <td><?php echo $user['Email']; ?></td>
                        <td><?php echo ($user['Role'] == 1) ? 'Quản trị viên' : 'Người dùng'; ?></td>
                        <td>
                            <a href="admin_update_user.php?id=<?php echo $user['ID']; ?>">Chỉnh sửa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
