<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GTPT"; // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID phòng trọ từ URL
$motel_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($motel_id > 0) {
    // Truy vấn thông tin phòng trọ theo ID
    $query = "SELECT MOTEL.*, USER.Name AS owner_name, USER.Phone AS owner_phone
              FROM MOTEL
              JOIN USER ON MOTEL.user_id = USER.ID
              WHERE MOTEL.ID = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $motel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $motel = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy phòng trọ.";
        exit();
    }
} else {
    echo "ID phòng trọ không hợp lệ.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Phòng trọ</title>
    <style>
        /* CSS cơ bản */
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .motel-header { margin-bottom: 20px; }
        .motel-header h1 { font-size: 28px; }
        .motel-details { margin-bottom: 20px; }
        .motel-details img { max-width: 100%; height: auto; }
        .motel-info p { margin: 5px 0; }
        .motel-info strong { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="motel-header">
            <h1><?php echo htmlspecialchars($motel['title']); ?></h1>
            <p><strong>Giá:</strong> <?php echo number_format($motel['price']); ?> VND</p>
            <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($motel['address']); ?></p>
        </div>

        <div class="motel-details">
            <img src="<?php echo htmlspecialchars($motel['images']); ?>" alt="Hình ảnh phòng trọ">
            <p><strong>Mô tả chi tiết:</strong> <?php echo nl2br(htmlspecialchars($motel['description'])); ?></p>
            <p><strong>Diện tích:</strong> <?php echo htmlspecialchars($motel['area']); ?> m²</p>
            <p><strong>Tiện ích:</strong> <?php echo htmlspecialchars($motel['utilities']); ?></p>
        </div>

        <div class="motel-info">
            <p><strong>Lượt xem:</strong> <?php echo htmlspecialchars($motel['count_view']); ?></p>
            <p><strong>Chủ trọ:</strong> <?php echo htmlspecialchars($motel['owner_name']); ?></p>
            <p><strong>Điện thoại liên hệ:</strong> <?php echo htmlspecialchars($motel['owner_phone']); ?></p>
            <p><strong>Ngày đăng:</strong> <?php echo htmlspecialchars($motel['created_at']); ?></p>
        </div>
    </div>
</body>
</html>
