<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_number = $_POST['order_number'];
    $review_content = $_POST['review_content'];
    $user_id = $_SESSION['user_id']; // 假設用戶ID已存在於會話中

    // 處理評論圖片
    $review_image = null;
    if (isset($_FILES['review_image']) && $_FILES['review_image']['error'] === UPLOAD_ERR_OK) {
        $image_data = file_get_contents($_FILES['review_image']['tmp_name']);
        $review_image = base64_encode($image_data);
    }

    // 查询产品对应的商店编号
    $query_store_number = "SELECT store_info.STNumber FROM product
                           INNER JOIN store_info ON product.seller_ID = store_info.seller_ID
                           WHERE product.PNumber IN (
                               SELECT `order item`.PNumber FROM `order item`
                               WHERE `order item`.ONumber = ?
                           )";
    $stmt_store_number = mysqli_prepare($link, $query_store_number);
    mysqli_stmt_bind_param($stmt_store_number, 's', $order_number);
    mysqli_stmt_execute($stmt_store_number);
    mysqli_stmt_bind_result($stmt_store_number, $store_number);
    mysqli_stmt_fetch($stmt_store_number);
    mysqli_stmt_close($stmt_store_number);

    // 插入评论到数据库
    $query_insert_review = "INSERT INTO review (OINumber, ID, ReviewContent, img, ReviewTime, STNumber) VALUES (?, ?, ?, ?, NOW(), ?)";
    $stmt_insert_review = mysqli_prepare($link, $query_insert_review);
    mysqli_stmt_bind_param($stmt_insert_review, 'sissi', $order_number, $user_id, $review_content, $review_image, $store_number);

    if (mysqli_stmt_execute($stmt_insert_review)) {
        echo json_encode(['success' => true]);
        // 成功提交评论后重定向到原页面
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => '插入評論失敗: ' . mysqli_error($link)]);
    }

    mysqli_stmt_close($stmt_insert_review);
}

mysqli_close($link);
?>
