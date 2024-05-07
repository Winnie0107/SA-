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
    die("Error updating order: " . mysqli_error($link));
}

// 獲取訂單詳細信息
$select_query = "SELECT * FROM p_order WHERE ONumber = '$order_number'";
$select_result = mysqli_query($link, $select_query);

if (!$select_result) {
    die("Error fetching order details: " . mysqli_error($link));
}

$order_details = mysqli_fetch_assoc($select_result);

// 獲取買家郵件地址
$buyer_id = $order_details['buyer_ID'];
$user_query = "SELECT email FROM user WHERE ID = '$buyer_id'";
$user_result = mysqli_query($link, $user_query);

if (!$user_result) {
    die("Error fetching buyer email: " . mysqli_error($link));
}

$user_data = mysqli_fetch_assoc($user_result);
$buyer_email = $user_data['email'];

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
    $mail->addAddress($buyer_email);
    $mail->Subject = '=?UTF-8?B?' . base64_encode('訂單取消通知') . '?='; 
    $mail->Body = "您的訂單已取消。\n\n取消原因：$cancel_reason\n\n";
    $mail->send();

    // 發送郵件給賣家
    foreach ($_SESSION['order_details'] as $seller_ID => $order_data) {
        $mail->clearAddresses(); // 清除之前的收件人
    
        // 添加卖家的邮件地址
        $mail->addAddress($_SESSION['seller_email'][$seller_ID]);
    
        // 生成邮件内容
        $mailContent = "您收到一份新的订单取消通知：\n\n";
        foreach ($order_data as $order) {
            $mailContent .= "订单号：{$order['ONumber']}\n";
            $mailContent .= "取消原因：$cancel_reason\n\n";
        }
        // 你可以在这里添加更多相关于卖家的信息
    
        // 设置邮件主题和内容
        $mail->Subject = '=?UTF-8?B?' . base64_encode('订单取消通知') . '?='; 
        $mail->Body = $mailContent;
    
        // 发送邮件
        $mail->send();
    }

    // 跳轉到某個頁面
    header("Location: ../SA_front_end/buyer_order.php");
    exit();

} catch (Exception $e) {
    echo '發送郵件時出現錯誤：' . $mail->ErrorInfo;
}
?>
