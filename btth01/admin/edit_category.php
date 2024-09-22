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
require('../connect.php'); 
if (isset($_GET['ma_tloai'])) {
    $ma_tloai = $_GET['ma_tloai']; 

    $sql = "SELECT * FROM theloai WHERE ma_tloai = :ma_tloai";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['ma_tloai' => $ma_tloai]);
    $category = $stmt->fetch();

    if (!$category) {
        echo "Thể loại không tồn tại!";
        exit;
    }

    if (isset($_POST['Luu_lai'])) {
        $ten_tloai = $_POST['ten_tloai'];

        if (empty($ten_tloai)) {
            echo "Vui lòng nhập tên thể loại!";
        } else 
        {
            $sql = "UPDATE theloai SET ten_tloai = :ten_tloai WHERE ma_tloai = :ma_tloai";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'ten_tloai' => $ten_tloai,
                'ma_tloai' => $ma_tloai 
            ]);
            header("Location: category.php");
            exit;
        }
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
                        <a class="nav-link active fw-bold" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>

    </header>
    <main class="container mt-5 mb-5">
        <!-- <h3 class="text-center text-uppercase mb-3 text-primary">CẢM NHẬN VỀ BÀI HÁT</h3> -->
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold ">Sửa thông tin thể loại</h3>
                <form action="edit_category.php?ma_tloai=<?php echo $ma_tloai; ?>" method="post">
                
                    <div class="input-group mt-3 mb-3">
                            <span class="input-group-text col-2 text-center" id="lblCatId">Mã thể loại</span>
                            <!-- <input type="text" class="form-control" name="txtCatId" readonly value="1"> -->
                            <input type="number" class="form-control col-10" name="ma_tloai" value="<?php echo $category['ma_tloai']; ?>" readonly>

                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text col-2 text-center" id="lblCatName">Tên thể loại</span>
                        <input type="text" class="form-control col-10" name="ten_tloai" value="<?php echo $category['ten_tloai']; ?>" required>

                    </div>

                    <div class="form-group  float-end ">
                        <button type="submit" name="Luu_lai" class="btn btn-primary">Lưu lại</button>
                        <a href="category.php" class="btn btn-warning ">Quay lại</a>
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