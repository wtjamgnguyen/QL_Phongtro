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
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $address = $_POST['address'];
    $district_id = $_POST['district_id'];
    $utilities = $_POST['utilities'];
    $user_id = $_SESSION['user_id'];

    // Xử lý upload hình ảnh
    $target_dir = "uploads/";
    $image = $_FILES['image']['name'];
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    // Thêm phòng trọ vào cơ sở dữ liệu
    $query = "INSERT INTO MOTEL (title, description, price, address, district_id, utilities, images, user_id, created_at, approve) 
              VALUES ('$title', '$description', $price, '$address', $district_id, '$utilities', '$target_file', $user_id, NOW(), 0)";
    $conn->query($query);
    header("Location: manage_motel.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phòng trọ</title>
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
            <h1>Thêm phòng trọ mới</h1>
            <form action="add_motel.php" method="POST" enctype="multipart/form-data">
                <!-- Tiêu đề phòng trọ -->
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề phòng trọ:</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <!-- Mô tả chi tiết -->
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả chi tiết:</label>
                    <textarea class="form-control" name="description" rows="4" required></textarea>
                </div>

                <!-- Giá phòng -->
                <div class="mb-3">
                    <label for="price" class="form-label">Giá phòng (VND):</label>
                    <input type="number" class="form-control" name="price" required>
                </div>

                <!-- Địa chỉ -->
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ:</label>
                    <input type="text" class="form-control" name="address" required>
                </div>

                <!-- Khu vực -->
                <div class="mb-3">
                    <label for="district_id" class="form-label">Khu vực:</label>
                    <select class="form-select" name="district_id" required>
                        <?php
                        $districts_result = $conn->query("SELECT ID, Name FROM DISTRICTS");
                        while ($row = $districts_result->fetch_assoc()) {
                            echo "<option value='" . $row['ID'] . "'>" . $row['Name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Tiện ích -->
                <div class="mb-3">
                    <label for="utilities" class="form-label">Tiện ích:</label>
                    <input type="text" class="form-control" name="utilities" required>
                </div>

                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh:</label>
                    <input type="file" class="form-control" name="image" required>
                </div>

                <!-- Nút submit -->
                <button type="submit" class="btn btn-success w-100">Thêm phòng trọ</button>
            </form>
        </div>
    </div>

    <!-- Thêm Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
