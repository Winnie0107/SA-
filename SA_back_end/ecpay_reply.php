<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['CVSStoreName'])) {
        $storeName = $_POST['CVSStoreName'];
        // 將門市名稱作為 URL 參數傳遞，並將瀏覽器重定向回 SA-/SA_front_end/buyer_checkout.php
        header("Location: /SA-/SA_front_end/buyer_checkout.php?store=" . urlencode($storeName));
        exit(); 
    } 
} else {
    // 如果請求方法無效，返回錯誤消息
    http_response_code(405);
    echo 'Error: Invalid request method.';
}
?>
