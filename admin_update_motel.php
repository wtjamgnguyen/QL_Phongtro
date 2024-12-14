<?php
session_start();
if ($_SESSION['role'] != 1) {
    // Chỉ Admin mới có quyền truy cập
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "GTPT");

// Lấy danh sách phòng trọ
$query = "SELECT * FROM MOTEL";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa phòng trọ</title>
    <style>
        /* Thiết lập lại một số thuộc tính mặc định */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Cấu trúc tổng thể của trang */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
        }

        /* Container chính */
        .container {
            width: 80%;
            margin: 0 auto;
        }

        /* Tiêu đề trang */
        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            color: #4CAF50;
            font-size: 2rem;
        }

        /* Bảng */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Nút chỉnh sửa */
        a.btn-edit {
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a.btn-edit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Chọn phòng trọ cần chỉnh sửa</h1>
        </header>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Giá phòng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($motel = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $motel['ID']; ?></td>
                        <td><?php echo htmlspecialchars($motel['title']); ?></td>
                        <td><?php echo number_format($motel['price']); ?> VND</td>
                        <td>
                            <a href="admin_update_motel_process.php?id=<?php echo $motel['ID']; ?>" class="btn-edit">Chỉnh sửa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
