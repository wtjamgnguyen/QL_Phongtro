<?php
// Kết nối đến CSDL MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GTPT"; // Tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận dữ liệu từ form
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Kiểm tra tính hợp lệ
    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($phone)) {
        echo "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Kiểm tra xem email hoặc username đã tồn tại chưa
        $checkUser = $conn->prepare("SELECT * FROM USER WHERE Username = ? OR Email = ?");
        $checkUser->bind_param("ss", $username, $email);
        $checkUser->execute();
        $result = $checkUser->get_result();

        if ($result->num_rows > 0) {
            echo "Tên đăng nhập hoặc email đã tồn tại!";
        } else {
            // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Chuẩn bị và thực thi câu lệnh SQL để lưu người dùng
            $stmt = $conn->prepare("INSERT INTO USER (Name, Username, Email, Password, Phone, Role) VALUES (?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("sssss", $name, $username, $email, $hashed_password, $phone);

            if ($stmt->execute()) {
                echo "Đăng ký thành công!";
                // Chuyển hướng tới trang đăng nhập
                header("Location: login.html");
                exit();
            } else {
                echo "Có lỗi xảy ra. Vui lòng thử lại.";
            }
        }
    }
}

// Đóng kết nối
$conn->close();
?>
