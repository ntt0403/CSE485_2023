<?php
require("../connect.php"); // Kết nối với cơ sở dữ liệu

if (isset($_GET['ma_bviet'])) {
    $ma_bviet = $_GET['ma_bviet'];

    // Chuẩn bị câu lệnh SQL để xóa bài viết
    $sql = "DELETE FROM baiviet WHERE ma_bviet = :ma_bviet";
    $stmt = $pdo->prepare($sql);

    // Thực thi câu lệnh
    if ($stmt->execute([':ma_bviet' => $ma_bviet])) {
        // Chuyển hướng về trang danh sách bài viết sau khi xóa thành công
        header("Location: article.php");
        exit;
    } else {
        echo "Lỗi khi xóa bài viết.";
    }
} else {
    echo "Không tìm thấy mã bài viết.";
}
?>