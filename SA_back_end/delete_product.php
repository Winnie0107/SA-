<?php
session_start();

$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

if(isset($_POST['PNumber'])) {
    $PNumber = $_POST['PNumber'];

    // 檢查是否為該使用者擁有的商品
    $query = "SELECT * FROM product WHERE PNumber = '$PNumber' AND seller_ID = '$user_id'";
    $result = mysqli_query($link, $query);

    if(mysqli_num_rows($result) > 0) {
        // 刪除商品
        $delete_query = "DELETE FROM product WHERE PNumber = '$PNumber'";
        $delete_result = mysqli_query($link, $delete_query);

        if($delete_result) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "Unauthorized";
    }
} else {
    echo "Invalid request";
}

mysqli_close($link);
?>
