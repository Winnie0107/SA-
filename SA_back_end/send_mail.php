<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php'; // 引入 PHPMailer 类

$mail = new PHPMailer(true);

try {
    // 服務器設置
    $mail->SMTPDebug = 0; // 調適模式：0=關閉，1=客户端，2=客户端和服务器
    $mail->isSMTP(); // 使用 SMTP
    $mail->Host = 'smtp.gmail.com'; // SMTP 服務器地址
    $mail->SMTPAuth = true; // SMTP 認證
    $mail->Username = 'peggylin0616@gmail.com'; // Gmail
    $mail->Password = 'dvudxzyiqzafwzxm'; // 應用程序密码
    $mail->SMTPSecure = 'tls'; // 使用 TLS 加密
    $mail->Port = 587; // SMTP 端口號

    // 收件人和郵件内容
    $mail->setFrom('peggylin0616@gmail.com', '=?UTF-8?B?' . base64_encode('惜物盲盒平台') . '?=', true);

    $mail->addAddress('peggylin0616@gmail.com', '=?UTF-8?B?' . base64_encode('Recipient Name') . '?=');

    $mail->Subject = '=?UTF-8?B?' . base64_encode('惜物盲盒：下單成功通知') . '?='; // 郵件主題

    $mail->Body = '親愛的[收件人姓名]，

    感謝您在我們的網站上下單。您的訂單已成功提交並且正在處理中。
    
    以下是您的訂單詳細信息：
    訂單編號：[訂單編號]
    下單日期：[下單日期]
    商品名稱：[商品名稱]
    數量：[數量]
    總價：[總價]
    
    我們將盡快處理您的訂單。如果您有任何疑問或需要幫助，請隨時與我們聯繫。
    
    謝謝您的購買！
    
    惜物盲盒平台 敬上'; 

    $mail->send();
    echo '邮件已发送成功！';
} catch (Exception $e) {
    echo '发送邮件时出现错误：' . $mail->ErrorInfo;
}
?>