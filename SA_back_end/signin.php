<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = mysqli_connect('localhost', 'root', '12345678');
    mysqli_select_db($link, 'box');

    $account = isset($_POST['account']) ? mysqli_real_escape_string($link, $_POST['account']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($link, $_POST['password']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($link, $_POST['email']) : '';
    $acco_level = isset($_POST['acco_level']) ? mysqli_real_escape_string($link, $_POST['acco_level']) : '';

    $default_img_path = 'C:\AppServ\www\SA-\images\penguin.jpg';

    // 讀取預設圖片文件並轉換為二進制格式
    $default_img_content = addslashes(file_get_contents($default_img_path));

    // 插入用戶信息和預設圖片到資料庫
    $sql = "INSERT INTO user (account, password, email, acco_level, img) VALUES ('$account', '$password', '$email', '$acco_level', '$default_img_content')";

    $user_id = $user['ID'];

    if (mysqli_query($link, $sql)) {
        $user_id = mysqli_insert_id($link);
    
        $insert_cart_query = "INSERT INTO `shopping cart` (buyer_ID) VALUES (?)";
        $stmt = mysqli_prepare($link, $insert_cart_query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $cart_id = mysqli_insert_id($link);
            $_SESSION['SNumber'] = $cart_id;
        } else {
            die("Error: " . mysqli_error($link));
        }
        mysqli_stmt_close($stmt);
        echo "<script>alert('註冊成功！'); window.location.href = 'http://localhost/SA-/SA_front_end/login.php';</script>";
        exit();
    } else {
        echo "錯誤: " . $sql . "<br>" . mysqli_error($link);
    }
}    
?>