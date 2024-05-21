<?php
session_start();

if (isset($_POST['PNumber'])) { // Change from 'SINumber' to 'PNumber'
    $PNumber = $_POST['PNumber']; // Change variable name from 'SINumber' to 'PNumber'
    $link = mysqli_connect('localhost', 'root', '12345678', 'box');

    if (!$link) {
        die("連線失敗: " . mysqli_connect_error());
    }

    $delete_cart_item = "DELETE FROM `shopping cart item` WHERE PNumber = ?"; // Change column name to 'PNumber'
    $stmt = mysqli_prepare($link, $delete_cart_item);
    mysqli_stmt_bind_param($stmt, "i", $PNumber); // Change variable name to 'PNumber'

    if (mysqli_stmt_execute($stmt)) {

        // 刪除成功後重定向回購物車頁面
        header("Location: ../SA_front_end/buyer_checkout.php");
        exit();
    } else {
        echo "錯誤: " . mysqli_error($link);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>