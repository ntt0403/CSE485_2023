<?php
    if (isset($_GET['query'])) 
    {
        $query = trim($_GET['query']); 
        if ($query === 'thể loại') {
            header("Location: admin/category.php");
            exit();
        } 
        elseif ($query === 'tác giả') {
            header("Location: admin/author.php");
            exit();
        } 
        elseif ($query === 'bài viết') {
            header("Location: admin/article.php");
            exit();
        } 
        else {
            echo "Không tìm thấy nội dung.";
        }
    } 
    else {
        echo "Vui lòng nhập nội dung tìm kiếm.";
    }
?>

