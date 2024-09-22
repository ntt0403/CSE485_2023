<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thể Loại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require('../connect.php'); // Kết nối với cơ sở dữ liệu

if (isset($_GET['ma_tloai'])) {
    $ma_tloai = $_GET['ma_tloai'];

    // Lấy thông tin thể loại để hiển thị
    $sql = "SELECT * FROM theloai WHERE ma_tloai = :ma_tloai";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['ma_tloai' => $ma_tloai]);
    $category = $stmt->fetch();

    if (!$category) {
        echo "Thể loại không tồn tại!";
        exit;
    }

    if (isset($_POST['sua_tloai'])) {
        $ten_tloai = $_POST['ten_tloai'];

        if (empty($ten_tloai)) {
            echo "Vui lòng nhập tên thể loại!";
        } else {
            $sql = "UPDATE theloai SET ten_tloai = :ten_tloai WHERE ma_tloai = :ma_tloai";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'ten_tloai' => $ten_tloai,
                'ma_tloai' => $ma_tloai
            ]);

            echo "Sửa thể loại thành công!";
            header("Location: category.php"); // Chuyển hướng về trang danh sách thể loại
            exit;
        }
    }
}
?>
<div class="container mt-5">
    <h2 class="text-center">Sửa Thể Loại</h2>
    <form action="edit_category.php?ma_tloai=<?php echo $ma_tloai; ?>" method="post">
        <div class="mb-3">
            <label for="ma_tloai" class="form-label">Mã Thể Loại</label>
            <input type="number" class="form-control" name="ma_tloai" value="<?php echo $category['ma_tloai']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="ten_tloai" class="form-label">Tên Thể Loại</label>
            <input type="text" class="form-control" name="ten_tloai" value="<?php echo $category['ten_tloai']; ?>" required>
        </div>
        <button type="submit" name="sua_tloai" class="btn btn-primary">Sửa</button>
        <a href="category.php" class="btn btn-warning">Quay lại</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
