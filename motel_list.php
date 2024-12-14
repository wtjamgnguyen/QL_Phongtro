<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GTPT";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$query_views = "SELECT * FROM MOTEL ORDER BY count_view DESC LIMIT 5";
$result_views = $conn->query($query_views);

$query_new = "SELECT * FROM MOTEL ORDER BY created_at DESC LIMIT 5";
$result_new = $conn->query($query_new);

$vinh_lat = 18.6725;
$vinh_lng = 105.6978;

function calculate_distance($lat1, $lng1, $lat2, $lng2) {
    $earth_radius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLng = deg2rad($lng2 - $lng1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) * sin($dLng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earth_radius * $c;
    return $distance;
}

$query_vinh = "SELECT *, SUBSTRING_INDEX(latlng, ',', 1) AS lat, SUBSTRING_INDEX(latlng, ',', -1) AS lng FROM MOTEL";
$result_vinh = $conn->query($query_vinh);
$motels_near_vinh = [];

if ($result_vinh->num_rows > 0) {
    while ($row = $result_vinh->fetch_assoc()) {
        $distance = calculate_distance($vinh_lat, $vinh_lng, $row['lat'], $row['lng']);
        if ($distance <= 5) {
            $row['distance'] = $distance;
            $motels_near_vinh[] = $row;
        }
    }
}

usort($motels_near_vinh, function ($a, $b) {
    return $a['distance'] <=> $b['distance'];
});

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phòng trọ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .section-title {
            text-align: center;
            margin: 40px 0;
            font-size: 28px;
            font-weight: bold;
            color: #343a40;
        }
        .navbar {
            margin-bottom: 40px;
        }
        .card-title, .card-text {
            font-size: 16px;
            color: #495057;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Thêm thanh điều hướng (navbar) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <a class="navbar-brand" href="#">Quản lý Phòng trọ</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="motel_search.php">Tìm kiếm phòng trọ</a>
                </li>
            </ul>
        </div>
    </nav>

    <h1 class="section-title">Danh sách Phòng trọ</h1>

    <!-- Phòng trọ xem nhiều nhất -->
    <div class="row">
        <h2 class="section-title">Phòng trọ xem nhiều nhất</h2>
        <?php if ($result_views->num_rows > 0): ?>
            <?php while ($row = $result_views->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="<?php echo $row['images']; ?>" class="card-img-top" alt="Hình ảnh phòng trọ">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text">Giá: <?php echo number_format($row['price']); ?> VND</p>
                            <p class="card-text">Địa chỉ: <?php echo $row['address']; ?></p>
                            <p class="card-text">Lượt xem: <?php echo $row['count_view']; ?></p>
                            <a href="motel_detail.php?id=<?php echo $row['ID']; ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Không có phòng trọ nào.</p>
        <?php endif; ?>
    </div>

    <!-- Phòng trọ mới đăng tải -->
    <div class="row">
        <h2 class="section-title">Phòng trọ mới đăng tải</h2>
        <?php if ($result_new->num_rows > 0): ?>
            <?php while ($row = $result_new->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="<?php echo $row['images']; ?>" class="card-img-top" alt="Hình ảnh phòng trọ">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text">Giá: <?php echo number_format($row['price']); ?> VND</p>
                            <p class="card-text">Địa chỉ: <?php echo $row['address']; ?></p>
                            <p class="card-text">Ngày đăng: <?php echo $row['created_at']; ?></p>
                            <a href="motel_detail.php?id=<?php echo $row['ID']; ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Không có phòng trọ nào.</p>
        <?php endif; ?>
    </div>

    <!-- Phòng trọ gần Đại học Vinh nhất -->
    <div class="row">
        <h2 class="section-title">Phòng trọ gần Đại học Vinh nhất</h2>
        <?php if (!empty($motels_near_vinh)): ?>
            <?php foreach ($motels_near_vinh as $motel): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="<?php echo $motel['images']; ?>" class="card-img-top" alt="Hình ảnh phòng trọ">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $motel['title']; ?></h5>
                            <p class="card-text">Giá: <?php echo number_format($motel['price']); ?> VND</p>
                            <p class="card-text">Địa chỉ: <?php echo $motel['address']; ?></p>
                            <p class="card-text">Khoảng cách: <?php echo round($motel['distance'], 2); ?> km</p>
                            <a href="motel_detail.php?id=<?php echo $motel['ID']; ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có phòng trọ nào gần Đại học Vinh.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
