<?php
require("../connect.php"); 

if (isset($_GET['ma_bviet'])) {
    $ma_bviet = $_GET['ma_bviet'];

    $sql = "DELETE FROM baiviet WHERE ma_bviet = :ma_bviet";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([':ma_bviet' => $ma_bviet])) {
        header("Location: article.php");
        exit;
    } else {
        echo "Lỗi khi xóa bài viết.";
    }
} else {
    echo "Không tìm thấy mã bài viết.";
}
?>