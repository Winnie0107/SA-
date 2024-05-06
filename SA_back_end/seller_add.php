<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $PName = isset($_POST['PName']) ? mysqli_real_escape_string($link, $_POST['PName']) : '';
    $category = isset($_POST['category']) ? mysqli_real_escape_string($link, $_POST['category']) : '';
    $price = isset($_POST['price']) ? mysqli_real_escape_string($link, $_POST['price']) : '';
    $details = isset($_POST['details']) ? mysqli_real_escape_string($link, $_POST['details']) : '';
    $quantity = isset($_POST['quantity']) ? mysqli_real_escape_string($link, $_POST['quantity']) : '';

    // Set default image path based on price range
    // 使用正則表達式檢查價格格式
    if (preg_match('/^\$\d+$/', $price)) {
        $price_value = intval(substr($price, 1)); // 提取價格數字部分並轉換為整數
        if ($price_value > 0 && $price_value <= 500) {
            $default_img_path = 'C:\AppServ\www\SA-\images\500.jpg';
        } elseif ($price_value > 500 && $price_value <= 1000) {
            $default_img_path = 'C:\AppServ\www\SA-\images\1000.jpg';
        } elseif ($price_value > 1000 && $price_value <= 1500) {
            $default_img_path = 'C:\AppServ\www\SA-\images\1500.jpg';
        } else {
            // 如果價格超出了範圍，設置一個默認的圖片路徑
            $default_img_path = 'C:\AppServ\www\SA-\images\best.jpg';
        }
    } else {
        // 如果價格格式不符合要求，設置一個默認的圖片路徑
        $default_img_path = 'C:\AppServ\www\SA-\images\error.jpg';
    }


    // Read default image file and convert to binary format
    $default_img_content = addslashes(file_get_contents($default_img_path));

    $result = mysqli_query($link, "INSERT INTO product (seller_ID, PName, category, price, details, quantity, img) 
        VALUES ('$user_id', '$PName', '$category', '$price', '$details', '$quantity', '$default_img_content')");

    if ($result) {
        echo "<script>window.location.href = 'http://localhost/SA-/SA_front_end/seller_confirmation.php';</script>";
        exit();
    } else {
        echo "新增失敗，請重試";
    }
}
?>
