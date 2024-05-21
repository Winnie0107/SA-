<?php
session_start();

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php'; // 引入 PHPMailer 

// 獲取取消訂單信息
$order_number = $_POST['order_number'];
$cancel_reason = $_POST['cancel_reason'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 更新訂單狀態和取消原因
$update_query = "UPDATE p_order SET state = 0, reason_for_cancel = '$cancel_reason' WHERE ONumber = '$order_number'";
$update_result = mysqli_query($link, $update_query);

if (!$update_result) {
    die("更新訂單時出錯: " . mysqli_error($link));
}

// 獲取訂單詳細信息
$select_query = "SELECT p_order.*, user.account AS buyer_name, user.email AS buyer_email
                FROM p_order
                INNER JOIN user ON p_order.buyer_ID = user.ID
                WHERE ONumber = '$order_number'";
$select_result = mysqli_query($link, $select_query);

if (!$select_result) {
    die("獲取訂單詳細信息時出錯: " . mysqli_error($link));
}

$order_details = mysqli_fetch_assoc($select_result);

// 獲取賣家郵件地址和訂單詳情
$seller_query = "SELECT user.email AS seller_email, product.PName, store_info.STName, `order item`.quantity, product.price 
                 FROM `order item`
                 JOIN product ON `order item`.PNumber = product.PNumber
                 JOIN user ON product.seller_ID = user.ID
                 JOIN store_info ON user.ID = store_info.seller_ID
                 WHERE `order item`.ONumber = '$order_number'";
$seller_result = mysqli_query($link, $seller_query);

if (!$seller_result) {
    die("獲取賣家郵件地址和訂單詳情時出錯: " . mysqli_error($link));
}

$seller_emails = [];
$order_items = [];

while ($row = mysqli_fetch_assoc($seller_result)) {
    $seller_emails[$row['seller_email']] = $row['seller_email']; // 收集唯一的賣家郵件地址
    $order_items[] = [
        'product_name' => $row['PName'],
        'quantity' => $row['quantity'],
        'price' => $row['price'],
        'seller_name' => $row['STName']
    ];
}

// 關閉資料庫連接
mysqli_close($link);

// 實例化 PHPMailer 對象
$mail = new PHPMailer(true);

try {
    // 伺服器設置
    $mail->SMTPDebug = 0; // 調適模式：0=關閉，1=客户端，2=客户端和服务器
    $mail->isSMTP(); // 使用 SMTP
    $mail->Host = 'smtp.gmail.com'; // SMTP 服務器地址
    $mail->SMTPAuth = true; // SMTP 認證
    $mail->Username = 'peggylin0616@gmail.com'; // Gmail
    $mail->Password = 'dvudxzyiqzafwzxm'; // 應用程序密码
    $mail->SMTPSecure = 'tls'; // 使用 TLS 加密
    $mail->Port = 587; // SMTP 端口號

    // 發送郵件給買家
    $mail->addAddress($order_details['buyer_email']);
    $mail->Subject = '=?UTF-8?B?' . base64_encode('惜物盲盒：訂單取消通知') . '?=';
    $mailContent = "{$order_details['buyer_name']} 您好，很遺憾的通知您，您的訂單已被取消。\n\n取消原因：$cancel_reason\n\n";

    $mailContent .= "以下是訂單詳情：\n";

    $mailContent .= "商店名稱：{$order_items[0]['seller_name']}\n"; 
    foreach ($order_items as $item) {
        $mailContent .= "商品名稱：{$item['product_name']}\n";
        $mailContent .= "數量：{$item['quantity']}\n";
        $mailContent .= "總價：{$item['price']}\n\n";
    }
    $mailContent .= "如果您有任何疑問或需要幫助，請隨時與我們聯繫。感謝您的理解與支持！\n\n惜物盲盒平台 敬上\n\n";

    $mail->Body = $mailContent;
    $mail->send();

    // 發送郵件給賣家
    foreach ($seller_emails as $seller_email) {
        $mail->clearAddresses(); // 清除之前的收件人
        $mail->addAddress($seller_email);

        $mailContent = "很遺憾的通知您\n商店 {$item['seller_name']} 收到一份新的訂單取消通知：\n\n";
        $mailContent .= "取消原因：$cancel_reason\n\n";

        $mailContent .= "以下是訂單詳情：\n";
        foreach ($order_items as $item) {
            $mailContent .= "商品名稱：{$item['product_name']}\n";
            $mailContent .= "數量：{$item['quantity']}\n";
            $mailContent .= "總價：{$item['price']}\n\n";

        }
        $mailContent .= "買家：{$order_details['buyer_name']}\n";
        $mailContent .= "買家郵件：{$order_details['buyer_email']}\n\n";
        $mailContent .= "如果您有任何疑問或需要幫助，請隨時與我們聯繫。感謝您的理解與支持！\n\n惜物盲盒平台 敬上\n\n";

        $mail->Subject = '=?UTF-8?B?' . base64_encode('惜物盲盒：訂單取消通知') . '?=';
        $mail->Body = $mailContent;
        $mail->send();
    }

    // 跳轉到某個頁面
    if ($order_details['buyer_ID'] == $_SESSION['user_id']) {
        // 如果訂單取消者是買家，導向買家訂單頁面
        header("Location: ../SA_front_end/buyer_order.php");
    } else {
        // 否則，導向賣家訂單頁面
        header("Location: ../SA_front_end/seller_order.php");
    }
    exit();

} catch (Exception $e) {
    echo '發送郵件時出現錯誤：' . $mail->ErrorInfo;
}
?>