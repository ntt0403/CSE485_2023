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
?>
<?php
if (isset($_POST['Thêm'])) {
    // Lấy dữ liệu từ biểu mẫu
    $ma_bviet = $_POST['txtMaBViet'];
    $tieude = $_POST['txtTieuDe'];
    $ten_bhat = $_POST['txtTenBhat'];
    $ma_tloai = $_POST['txtMaTLoai'];
    $tomtat = $_POST['txtTomTat'];
    //$noidung = $_POST['noidung'];
    $ma_tgia = $_POST['txtMaTGia'];
    $ngayviet = $_POST['ngayviet'];

    // Xử lý upload hình ảnh
   //$hinhanh = $_FILES['hinhanh'];
    //$hinhanh_path = 'uploads/' . basename($hinhanh['name']);
    //move_uploaded_file($hinhanh['tmp_name'], $hinhanh_path);

    // Chuẩn bị câu lệnh SQL
    if (empty($ma_bviet) || empty($tieude) || empty($ten_bhat) || empty($ma_tloai) || empty($tomtat) || empty($ma_tgia) || empty($ngayviet)) {
        echo "Vui lòng nhập đầy đủ thông tin!";
    } else {
        $sql = "INSERT INTO baiviet (ma_bviet, tieude, ten_bhat, ma_tloai, tomtat,/* noidung,*/ ma_tgia, ngayviet/*, hinhanh*/) VALUES (:ma_bviet, :tieude, :ten_bhat, :ma_tloai, :tomtat/*, :noidung*/, :ma_tgia, :ngayviet/*, :hinhanh*/)";
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
                        <a class="nav-link " href="category.php">Thể loại</a>
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
                <h3 class="text-center text-uppercase fw-bold">Thêm mới bài viết</h3>
                <form action="add_article.php" method="post">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Mã bài viết</span>
                        <input type="text" class="form-control" name="txtMaBViet" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Tiêu đề</span>
                        <input type="text" class="form-control" name="txtTieuDe" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Tên bài hát</span>
                        <input type="text" class="form-control" name="txtTenBhat" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Mã thể loại</span>
                        <input type="text" class="form-control" name="txtMaTLoai" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Tóm tắt</span>
                        <input type="text" class="form-control" name="txtTomTat" required>
                    </div>

                    <!--<div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Nội dung</span>
<textarea class="form-control" name="txtNoiDung" required></textarea>
                    </div>-->

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Mã tác giả</span>
                        <input type="text" class="form-control" name="txtMaTGia" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Ngày viết</span>
                        <input type="date" class="form-control" name="ngayviet" required>
                    </div>

                    <!--<div class="mb-3">
                        <span class="input-group-text">Hình ảnh</span>
                        <input type="file" class="form-control" name="hinhanh" accept="image/*" required>
                    </div>-->

                    <div class="form-group float-end">
                        <input type="submit" name="Thêm" value="Thêm" class="btn btn-success">
                        <a href="article.php" class="btn btn-warning">Quay lại</a>
                    </div>

                </form>
            </div>
        </div>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary  border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>