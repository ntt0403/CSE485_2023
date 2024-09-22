<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style_login.css">
</head>

<?php
require("../connect.php"); // Kết nối với cơ sở dữ liệu

$baiviet = null; // Khởi tạo biến baiviet

if (isset($_GET['ma_bviet'])) { // Lấy ID bài viết từ URL
    $ma_bviet = $_GET['ma_bviet'];

    // Lấy thông tin bài viết
    $sql = "SELECT * FROM baiviet WHERE ma_bviet = :ma_bviet";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':ma_bviet' => $ma_bviet]);
    $baiviet = $stmt->fetch();

    if (!$baiviet) {
        echo "Bài viết không tồn tại.";
        exit;
    }
}

if (isset($_POST['Luu_lai'])) { // Thay 'Thêm' thành 'Lưu lại'
    // Lấy dữ liệu từ biểu mẫu
    $ma_bviet = $_POST['txtMaBViet'];
    $tieude = $_POST['txtTieuDe'];
    $ten_bhat = $_POST['txtTenBhat'];
    $ma_tloai = $_POST['txtMaTLoai'];
    $tomtat = $_POST['txtTomTat'];
    $ma_tgia = $_POST['txtMaTGia'];
    $ngayviet = $_POST['ngayviet'];

    // Chuẩn bị câu lệnh SQL
    if (empty($ma_bviet) || empty($tieude) || empty($ten_bhat) || empty($ma_tloai) || empty($tomtat) || empty($ma_tgia) || empty($ngayviet)) {
        echo "Vui lòng nhập đầy đủ thông tin!";
    } else {
        $sql = "UPDATE baiviet SET tieude = :tieude, ten_bhat = :ten_bhat, ma_tloai = :ma_tloai, tomtat = :tomtat, ma_tgia = :ma_tgia, ngayviet = :ngayviet WHERE ma_bviet = :ma_bviet"; // Đã sửa câu lệnh SQL
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':ma_bviet' => $ma_bviet,
            ':tieude' => $tieude,
            ':ten_bhat' => $ten_bhat,
            ':ma_tloai' => $ma_tloai,
            ':tomtat' => $tomtat,
            ':ma_tgia' => $ma_tgia,
            ':ngayviet' => $ngayviet,
        ]);
        
        // Thực thi câu lệnh
        header("Location: article.php");
        exit;
    }
}
?>



<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Trang ngoài</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Chỉnh sửa bài viết</h3>
                <form action="edit_article.php?ma_bviet=<?php echo $ma_bviet; ?>" method="post">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text col-2 text-center">Mã bài viết</span>
                        <input type="text" class="form-control col-10" name="txtMaBViet" value="<?php echo htmlspecialchars($baiviet['ma_bviet']); ?>" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text col-2 text-center">Tiêu đề</span>
                        <input type="text" class="form-control col-10" name="txtTieuDe" value="<?php echo htmlspecialchars($baiviet['tieude']); ?>" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text col-2 text-center">Tên bài hát</span>
                        <input type="text" class="form-control col-10" name="txtTenBhat" value="<?php echo htmlspecialchars($baiviet['ten_bhat']); ?>" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text col-2 text-center">Mã thể loại</span>
                        <input type="text" class="form-control col-10" name="txtMaTLoai" value="<?php echo htmlspecialchars($baiviet['ma_tloai']); ?>" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text col-2 text-center">Tóm tắt</span>
                        <input type="text" class="form-control col-10" name="txtTomTat" value="<?php echo htmlspecialchars($baiviet['tomtat']); ?>" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text col-2 text-center">Mã tác giả</span>
                        <input type="text" class="form-control col-10" name="txtMaTGia" value="<?php echo htmlspecialchars($baiviet['ma_tgia']); ?>" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text col-2 text-center">Ngày viết</span>
                        <input type="date" class="form-control col-10" name="ngayviet" value="<?php echo htmlspecialchars($baiviet['ngayviet']); ?>" required>
                    </div>

                    <div class="form-group float-end">
                        <button type="submit" name="Luu_lai" class="btn btn-primary">Lưu lại</button>
                        <a href="article.php" class="btn btn-warning">Quay lại</a>
                    </div>
                </form>

            </div>
        </div>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2 my-5" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
