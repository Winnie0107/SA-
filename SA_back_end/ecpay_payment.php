<?php
require('vendor/ECPay.Payment.Integration.php');

try {
    $AL = new ECPay_AllInOne();

    // 服務參數
    $AL->HashKey = '5294y06JbISpM5x9';
    $AL->HashIV = 'v77hoKGq4kWxNNIS';

    // 接收並檢查資料
    $feedback = $AL->CheckOutFeedback();

    if (sizeof($feedback) > 0) {
        $order_id = $feedback['MerchantTradeNo'];
        $order_status = $feedback['RtnCode'];

        header("Location: mail_order.php");
        exit;
    } else {
        echo '0|Fail';
    }
} catch (Exception $e) {
    echo '0|' . $e->getMessage();
}
?>
