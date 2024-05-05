<?php
session_start();

// 連接到資料庫
$link = mysqli_connect('localhost', 'root', '12345678', 'box');

// 檢查連接是否成功
if (!$link) {
    die("Error" . mysqli_connect_error());
}

// 檢查是否接收到POST請求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 檢查是否接收到SINumber值
    if (isset($_POST['SINumber'])) {
        // 接收SINumber值
        $SINumber = $_POST['SINumber'];

        // 使用SINumber刪除購物車項目
        $delete_query = "DELETE FROM `shopping cart item` WHERE SINumber = $SINumber";

        // 執行刪除資料的SQL查詢
        $delete_result = mysqli_query($link, $delete_query);

        // 檢查刪除操作是否成功
        if (!$delete_result) {
            die("Error" . mysqli_error($link));
        } else {
            // 刪除成功後，可以執行其他操作，例如重新導向到購物車頁面
            header("Location: buyer_cart.php");
            exit();
        }
    }
}

// 關閉資料庫連接
mysqli_close($link);
?>