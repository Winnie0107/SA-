<?php
session_start();

$keep_variables = array('user_account', 'user_level');

// 將購物車資訊存儲到資料庫中
if (isset($_SESSION['cart'])) {
    $user_id = $_SESSION['user_id'];
    $cart_contents = $_SESSION['cart'];

    $link = mysqli_connect('localhost', 'root', '12345678', 'box');
    if (!$link) {
        die("Error" . mysqli_connect_error());
    }

    foreach ($cart_contents as $PNumber => $quantity) {
        $insert_cart_item_query = "INSERT INTO `shopping cart item` (SNumber, PNumber, quantity) 
                                   VALUES ('$user_id', '$PNumber', '$quantity')";
        $result = mysqli_query($link, $insert_cart_item_query);
        if (!$result) {
            echo "Error inserting into shopping cart item: " . mysqli_error($link);
        }
    }

    mysqli_close($link);
}

// 清除 $_SESSION 中的變數
foreach ($_SESSION as $key => $value) {
    if (!in_array($key, $keep_variables)) {
        unset($_SESSION[$key]);
    }
}

session_destroy();

header("Location:../SA_front_end/index.php");
?>
