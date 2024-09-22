<?php
    if (isset($_GET['query'])) 
    {
        $query = trim(preg_replace('/\s+/', ' ', $_GET['query'])); // Loại bỏ các khoảng trắng thừa
        echo "Giá trị query: " . $query . "<br>";
    
        if (strcasecmp($query, 'Cây, lá và gió') === 0) {
            header("Location: detail.php?song=cayvagio");
            exit();
        } 
        elseif (strcasecmp($query, 'Cuộc sống mến thương') === 0) {
            header("Location: detail1.php?song=csmt");
            exit();
        } 
        elseif (strcasecmp($query, 'Lòng mẹ') === 0) {
            header("Location: detail2.php?song=longme");
            exit();
        }
        elseif (strcasecmp($query, 'Phôi pha') === 0) {
            header("Location: detail3.php?song=phoipha");
            exit();
        } 
        elseif (strcasecmp($query, 'Nơi tình yêu bắt đầu') === 0) {
            header("Location: detail4.php?song=noitinhyeubatdau");
            exit();
        } 
        else {
            echo "Không tìm thấy nội dung.";
        }
    } 
   
    
?>

