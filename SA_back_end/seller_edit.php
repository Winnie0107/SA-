<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $PNumber = $_GET['PNumber']; // 從 URL 參數中獲取商品編號

    // 獲取表單提交的修改後的商品資訊
    $PName = $_POST['PName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $details = $_POST['details'];
    $quantity = $_POST['quantity'];

    // 上傳的圖片處理
    if ($_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $img_data = addslashes(file_get_contents($_FILES['img']['tmp_name']));
    } else {
        // 如果沒有上傳新圖片，則保持原有圖片
        $link = mysqli_connect('localhost', 'root', '12345678', 'box');
        $query = "SELECT img FROM product WHERE PNumber = '$PNumber'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        $img_data = $row['img'];
    }

    // 更新資料庫中的商品資訊
    $link = mysqli_connect('localhost', 'root', '12345678', 'box');
    $query = "UPDATE product SET PName = '$PName', category = '$category', price = '$price', details = '$details', quantity = '$quantity', img = '$img_data' WHERE PNumber = '$PNumber'";
    $result = mysqli_query($link, $query);

    if ($result) {
        // 修改成功後重定向到商品列表頁面或其他需要顯示的頁面
        header("Location: seller_edit_finish.php");
        exit();
    } else {
        echo "修改商品資訊失敗，請重試。";
    }
}
?>
