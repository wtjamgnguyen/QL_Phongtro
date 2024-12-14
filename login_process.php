<?php
session_start();

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
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra xem username có tồn tại hay không
    $stmt = $conn->prepare("SELECT * FROM USER WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy thông tin người dùng
        $user = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['Password'])) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role'];

            // Điều hướng tới trang danh sách phòng trọ
            header("Location: motel_list.php");
            exit();
        } else {
            // Sai mật khẩu
            header("Location: login_form.php?error=Mật khẩu không đúng");
            exit();
        }
    } else {
        // Sai tên đăng nhập
        header("Location: login_form.php?error=Tên đăng nhập không tồn tại");
        exit();
    }
}

// Đóng kết nối
$conn->close();
?>
