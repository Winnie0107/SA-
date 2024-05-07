<?php
session_start();

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php'; // 引入 PHPMailer 

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

    // 收件人和郵件內容
    $mail->setFrom('peggylin0616@gmail.com', '=?UTF-8?B?' . base64_encode('惜物盲盒平台') . '?=', true);

    // 分组发送邮件
    foreach ($_SESSION['order_details'] as $seller_ID => $orders) {
        $mail->clearAddresses(); // 清除之前的收件人
        $mailContent = ''; // 重置郵件內容

        // 顯示一次購買者信息和訂單詳細信息
        $order = reset($orders); // 獲取第一個訂單
        $mailContent .= "{$order['user_name']} 您好，

感謝您在惜物盲盒平台上下單。您的訂單已成功提交並且正在處理中。
            
以下是您的訂單詳細信息：\n";

        foreach ($orders as $order) {
            // 顯示商品信息
            $mailContent .= "    購買商品：{$order['product_name']} 共 {$order['quantity']} 個\n";
            $mailContent .= "    總價：{$order['order_price']} 元\n";
        }

        $mailContent .= "    下單日期：{$order['order_date']}\n";
        $mailContent .= "    商店：{$order['seller_name']}\n";
        $mailContent .= "\n我們已將訂單傳達給商店。如果您有任何疑問或需要幫助，請隨時與我們聯繫。\n\n謝謝您的購買！\n\n惜物盲盒平台 敬上\n\n";

        // 這裡你需要確保 $_SESSION['user_email'] 中存在購買者的郵件地址
        if (isset($_SESSION['user_email'])) {
            $user_email = $_SESSION['user_email'];
            $mail->addAddress($user_email);
        } else {
            var_dump($_SESSION['user_email']);
            throw new Exception('找不到用戶郵件地址。');
        }

        // 將郵件內容設置為郵件主體
        $mail->Subject = '=?UTF-8?B?' . base64_encode('惜物盲盒：下單成功通知') . '?='; // 郵件主題
        $mail->Body = $mailContent;

        // 發送郵件
        $mail->send();
    }

    //給賣家
    foreach ($_SESSION['order_details'] as $seller_ID => $orders) {
        $mail->clearAddresses();

        $mailContent = ''; // 重置郵件內容

        // 賣家郵件
        $seller_email = $_SESSION['seller_email'][$seller_ID];

        $mail->addAddress($seller_email);


        $mailContent .= "感謝您使用惜物盲盒平台，\n\n";
        $mailContent .= "您收到一份新的訂單。\n\n";

        foreach ($orders as $order) {
            $mailContent .= "    購買商品：{$order['product_name']} 共 {$order['quantity']} 個\n";
            $mailContent .= "    總價：{$order['order_price']} 元\n";
        }

        $mailContent .= "    下單日期：{$order['order_date']}\n";
        $mailContent .= "    購買者：{$order['user_name']}\n";
        $mailContent .= "    購買者郵件地址：{$order['user_email']}\n";
        $mailContent .= "\n請及時處理訂單。如果您有任何疑問或需要幫助，請隨時與我們聯繫。\n\n祝生意興隆！\n\n惜物盲盒平台 敬上\n\n";

        // 设置邮件主题
        $mail->Subject = '=?UTF-8?B?' . base64_encode('惜物盲盒：新訂單通知') . '?=';

        // 设置邮件内容
        $mail->Body = $mailContent;

        // 发送邮件
        $mail->send();
    }


    // 跳轉到購買確認頁面
    echo "<script>window.location.href = 'http://localhost/SA-/SA_front_end/buyer_confirmation.php';</script>";
    exit();

} catch (Exception $e) {
    echo '發送郵件時出現錯誤：' . $mail->ErrorInfo;
    var_dump($seller_email);
}
?>