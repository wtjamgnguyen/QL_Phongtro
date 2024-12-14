<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm phòng trọ</title>
    <style>
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .search-form { margin-bottom: 20px; }
        .search-form label { display: block; margin-bottom: 10px; }
        .search-form input, .search-form select { width: 100%; padding: 8px; margin-bottom: 10px; }
        .search-results { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tìm kiếm phòng trọ</h1>
        <form action="search_motel.php" method="GET" class="search-form">
            <!-- Khoảng giá -->
            <label for="min_price">Giá từ:</label>
            <input type="number" name="min_price" placeholder="Nhập giá thấp nhất (VND)" value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : ''; ?>">

            <label for="max_price">Giá đến:</label>
            <input type="number" name="max_price" placeholder="Nhập giá cao nhất (VND)" value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : ''; ?>">

            <!-- Địa điểm -->
            <label for="district_id">Khu vực:</label>
            <select name="district_id">
                <option value="">Chọn khu vực</option>
                <?php
                // Truy vấn các khu vực từ bảng DISTRICTS
                $conn = new mysqli("localhost", "root", "", "GTPT");
                $districts_query = "SELECT ID, Name FROM DISTRICTS";
                $districts_result = $conn->query($districts_query);
                while ($row = $districts_result->fetch_assoc()) {
                    echo "<option value='" . $row['ID'] . "'>" . htmlspecialchars($row['Name']) . "</option>";
                }
                ?>
            </select>

            <!-- Tiện ích -->
            <label for="utilities">Tiện ích:</label>
            <input type="text" name="utilities" placeholder="Nhập tiện ích (ví dụ: wifi, máy lạnh)" value="<?php echo isset($_GET['utilities']) ? $_GET['utilities'] : ''; ?>">

            <!-- Nút tìm kiếm -->
            <button type="submit">Tìm kiếm</button>
        </form>

        <!-- Kết quả tìm kiếm -->
        <div class="search-results">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $min_price = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
                $max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : 0;
                $district_id = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;
                $utilities = isset($_GET['utilities']) ? $_GET['utilities'] : '';

                // Truy vấn phòng trọ theo các tiêu chí
                $query = "SELECT * FROM MOTEL WHERE 1=1";

                // Thêm điều kiện tìm kiếm theo khoảng giá
                if ($min_price > 0) {
                    $query .= " AND price >= $min_price";
                }
                if ($max_price > 0) {
                    $query .= " AND price <= $max_price";
                }

                // Thêm điều kiện tìm kiếm theo khu vực
                if ($district_id > 0) {
                    $query .= " AND district_id = $district_id";
                }

                // Thêm điều kiện tìm kiếm theo tiện ích
                if (!empty($utilities)) {
                    $query .= " AND utilities LIKE '%" . $conn->real_escape_string($utilities) . "%'";
                }

                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div>";
                        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                        echo "<p>Giá: " . number_format($row['price']) . " VND</p>";
                        echo "<p>Địa chỉ: " . htmlspecialchars($row['address']) . "</p>";
                        echo "<p>Tiện ích: " . htmlspecialchars($row['utilities']) . "</p>";
                        echo "<a href='detail_motel.php?id=" . $row['ID'] . "'>Xem chi tiết</a>";
                        echo "</div>";
                    }
                } else {
                    echo "Không tìm thấy kết quả nào.";
                }

                $conn->close();
            }
            ?>
        </div>
    </div>
</body>
</html>
