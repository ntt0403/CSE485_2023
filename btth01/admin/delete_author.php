<?php
require('../connect.php'); // Kết nối cơ sở dữ liệu

if (isset($_GET['ma_tgia'])) {
    $ma_tgia = $_GET['ma_tgia'];

    // Xóa tất cả các bài viết liên quan đến tác giả này trước
    $sql_baiviet = "DELETE FROM baiviet WHERE ma_tgia = :ma_tgia";
    $stmt_baiviet = $pdo->prepare($sql_baiviet);
    $stmt_baiviet->execute(['ma_tgia' => $ma_tgia]);

    // Sau khi đã xóa các bài viết, thực hiện xóa tác giả
    $sql_tacgia = "DELETE FROM tacgia WHERE ma_tgia = :ma_tgia";
    $stmt_tacgia = $pdo->prepare($sql_tacgia);

    if ($stmt_tacgia->execute(['ma_tgia' => $ma_tgia])) {
        // Chuyển hướng về trang danh sách sau khi xóa thành công
        header("Location: author.php");
    } else {
        echo "Xóa tác giả không thành công!";
    }
} else {
    echo "ID tác giả không được cung cấp!";
}
?>
