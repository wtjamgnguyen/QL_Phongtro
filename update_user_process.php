<?php
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GTPT"; // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];

// Kiểm tra phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Xử lý upload ảnh đại diện mới
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $target_dir = "uploads/";  // Thư mục lưu trữ ảnh
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra định dạng ảnh
        $valid_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $valid_extensions)) {
            // Lưu file ảnh
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                // Cập nhật đường dẫn ảnh trong CSDL
                $stmt = $conn->prepare("UPDATE USER SET Avatar = ? WHERE ID = ?");
                $stmt->bind_param("si", $target_file, $user_id);
                $stmt->execute();
            }
        } else {
            echo "Chỉ chấp nhận các định dạng JPG, JPEG, PNG & GIF.";
            exit();
        }
    }

    // Cập nhật thông tin khác (name, email, phone)
    $stmt = $conn->prepare("UPDATE USER SET Name = ?, Email = ?, Phone = ? WHERE ID = ?");
    $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
    if ($stmt->execute()) {
        echo "Cập nhật thông tin thành công!";
        header("Location: user_profile.php");  // Điều hướng về trang hồ sơ người dùng sau khi cập nhật thành công
        exit();
    } else {
        echo "Có lỗi xảy ra!";
    }
}

// Đóng kết nối
$conn->close();
?>
