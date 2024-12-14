<?php
session_start();
if ($_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "GTPT");

// Kiểm tra nếu có tham số 'id' trong URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID không hợp lệ.");
}

$id = $_GET['id'];

// Lấy thông tin phòng trọ từ cơ sở dữ liệu
$query = "SELECT * FROM MOTEL WHERE ID = $id";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    die("Phòng trọ không tồn tại.");
}

$motel = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        // Xóa phòng trọ
        $delete_query = "DELETE FROM MOTEL WHERE ID = $id";
        $conn->query($delete_query);
        header("Location: manage_motel.php");
        exit();
    } else {
        // Cập nhật thông tin phòng trọ
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $address = $_POST['address'];
        $utilities = $_POST['utilities'];
        
        $update_query = "UPDATE MOTEL SET title='$title', description='$description', price=$price, address='$address', utilities='$utilities' WHERE ID=$id";
        if ($conn->query($update_query)) {
            $message = "Cập nhật phòng trọ thành công!";
        } else {
            $message = "Có lỗi xảy ra trong quá trình cập nhật.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa phòng trọ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 0 auto;
        }
        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            margin-bottom: 20px;
            text-align: center;
        }
        .message.error {
            background-color: #f2dede;
            color: #a94442;
            border-color: #ebccd1;
        }
    </style>
</head>
<body>

    <h1>Chỉnh sửa phòng trọ</h1>

    <?php if (isset($message)): ?>
        <div class="message <?php echo isset($error) ? 'error' : ''; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form action="admin_update_motel.php?id=<?php echo $id; ?>" method="POST">
        <label for="title">Tiêu đề:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($motel['title']); ?>" required><br>

        <label for="description">Mô tả chi tiết:</label>
        <textarea name="description" required><?php echo htmlspecialchars($motel['description']); ?></textarea><br>

        <label for="price">Giá phòng (VND):</label>
        <input type="number" name="price" value="<?php echo $motel['price']; ?>" required><br>

        <label for="address">Địa chỉ:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($motel['address']); ?>" required><br>

        <label for="utilities">Tiện ích:</label>
        <input type="text" name="utilities" value="<?php echo htmlspecialchars($motel['utilities']); ?>" required><br>

        <button type="submit">Cập nhật</button>
    </form>

    <form action="admin_update_motel.php?id=<?php echo $id; ?>" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa phòng trọ này?');">
        <input type="hidden" name="delete" value="1">
        <button type="submit" style="background-color: #f44336;">Xóa phòng trọ</button>
    </form>

</body>
</html>
