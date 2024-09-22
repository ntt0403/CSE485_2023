<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tác Giả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require('../connect.php'); // Kết nối với cơ sở dữ liệu

if (isset($_POST['them_tgia'])) {
    $ma_tgia = $_POST['ma_tgia'];
    $ten_tgia = $_POST['ten_tgia'];
    $hinh_tgia = $_POST['hinh_tgia'];

    if (empty($ten_tgia)) {
        echo "Vui lòng nhập tên tác giả!";
    } else {
        $sql = "INSERT INTO tacgia (ma_tgia, ten_tgia, hinh_tgia) VALUES (:ma_tgia, :ten_tgia, :hinh_tgia)";
        $stmt = $pdo->prepare($sql);
        
        // Chạy câu lệnh với tham số
        $stmt->execute([
            'ma_tgia' => $ma_tgia,
            'ten_tgia' => $ten_tgia,
            'hinh_tgia' => $hinh_tgia
        ]);
        
        echo "Thêm tác giả thành công!";
        header("Location: author.php"); // Chuyển hướng về trang danh sách tác giả
        exit;
    }
}
?>
<div class="container mt-5">
    <h2 class="text-center">Thêm Tác Giả</h2>
    <form action="add_author.php" method="post">
        <div class="mb-3">
            <label for="ma_tgia" class="form-label">Mã Tác Giả</label>
            <input type="number" class="form-control" name="ma_tgia" required>
        </div>
        <div class="mb-3">
            <label for="ten_tgia" class="form-label">Tên Tác Giả</label>
            <input type="text" class="form-control" name="ten_tgia" required>
        </div>
        <div class="mb-3">
            <label for="hinh_tgia" class="form-label">Hình Tác Giả (URL)</label>
            <input type="text" class="form-control" name="hinh_tgia">
        </div>
        <button type="submit" name="them_tgia" class="btn btn-primary">Thêm</button>
        <a href="author.php" class="btn btn-warning">Quay lại</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
