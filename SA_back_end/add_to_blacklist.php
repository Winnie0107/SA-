<?php
session_start();

// 獲取請求參數
$buyer_id = intval($_GET['user']);
$seller_id = intval($_GET['seller']);
$cancel_count = intval($_GET['cancel_count']);

// 連接資料庫
$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 查找用戶名稱
$buyer_query = "SELECT account FROM user WHERE ID = '$buyer_id'";
$buyer_result = mysqli_query($link, $buyer_query);

if ($buyer_result && mysqli_num_rows($buyer_result) > 0) {
    $buyer_row = mysqli_fetch_assoc($buyer_result);
    $buyer_account = $buyer_row['account'];
} else {
    die("無法找到用戶: " . mysqli_error($link));
}

// 檢查是否已在黑名單中
$check_query = "SELECT * FROM blacklist WHERE buyer = '$buyer_id' AND seller = '$seller_id'";
$check_result = mysqli_query($link, $check_query);

if ($check_result && mysqli_num_rows($check_result) > 0) {
    echo "該買家已在黑名單中";
} else {
    // 插入黑名單記錄
    $insert_query = "INSERT INTO blacklist (buyer, seller, cancel_count) VALUES ('$buyer_id', '$seller_id', '$cancel_count')";
    $insert_result = mysqli_query($link, $insert_query);

    if ($insert_result) {
        echo "買家已成功加入黑名單";
    } else {
        die("插入黑名單失敗: " . mysqli_error($link));
    }
}

// 關閉資料庫連接
mysqli_close($link);
?>
