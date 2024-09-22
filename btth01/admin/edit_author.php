<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Tác Giả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require('../connect.php'); // Kết nối với cơ sở dữ liệu

if (isset($_GET['ma_tgia'])) {
    $ma_tgia = $_GET['ma_tgia'];

    // Lấy thông tin tác giả để hiển thị
    $sql = "SELECT * FROM tacgia WHERE ma_tgia = :ma_tgia";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['ma_tgia' => $ma_tgia]);
    $author = $stmt->fetch();

    if (!$author) {
        echo "Tác giả không tồn tại!";
        exit;
    }

    if (isset($_POST['sua_tgia'])) {
        $ten_tgia = $_POST['ten_tgia'];
        $hinh_tgia = $_POST['hinh_tgia'];

        if (empty($ten_tgia)) {
            echo "Vui lòng nhập tên tác giả!";
        } else {
            $sql = "UPDATE tacgia SET ten_tgia = :ten_tgia, hinh_tgia = :hinh_tgia WHERE ma_tgia = :ma_tgia";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'ten_tgia' => $ten_tgia,
                'hinh_tgia' => $hinh_tgia,
                'ma_tgia' => $ma_tgia
            ]);

            echo "Sửa tác giả thành công!";
            header("Location: author.php"); // Chuyển hướng về trang danh sách tác giả
            exit;
        }
    }
}
?>
<div class="container mt-5">
    <h2 class="text-center">Sửa Tác Giả</h2>
    <form action="edit_author.php?ma_tgia=<?php echo $ma_tgia; ?>" method="post">
        <div class="mb-3">
            <label for="ma_tgia" class="form-label">Mã Tác Giả</label>
            <input type="number" class="form-control" name="ma_tgia" value="<?php echo $author['ma_tgia']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="ten_tgia" class="form-label">Tên Tác Giả</label>
            <input type="text" class="form-control" name="ten_tgia" value="<?php echo $author['ten_tgia']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="hinh_tgia" class="form-label">Hình Tác Giả (URL)</label>
            <input type="text" class="form-control" name="hinh_tgia" value="<?php echo $author['hinh_tgia']; ?>">
        </div>
        <button type="submit" name="sua_tgia" class="btn btn-primary">Sửa</button>
        <a href="author.php" class="btn btn-warning">Quay lại</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
