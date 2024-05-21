<?php
// Start session
session_start();

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php'; // Include PHPMailer

$user_id = $_SESSION['user_id'];
$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Get the submitted title and content
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $content = mysqli_real_escape_string($link, $_POST['content']);
    // Get the current time
    $time = date("Y-m-d H:i:s");
    // Insert feedback into the database
    $query = "INSERT INTO feedback (user_id, title, content, time) VALUES ('$user_id', '$title', '$content', '$time')";

    if (mysqli_query($link, $query)) {
        echo "<script>alert('已成功提交！')</script>";

        // Instantiate PHPMailer object
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0; // Debug mode: 0=off, 1=client, 2=client and server
            $mail->isSMTP(); // Use SMTP
            $mail->Host = 'smtp.gmail.com'; // SMTP server address
            $mail->SMTPAuth = true; // SMTP authentication
            $mail->Username = 'peggylin0616@gmail.com'; // Gmail username
            $mail->Password = 'dvudxzyiqzafwzxm'; // Application password
            $mail->SMTPSecure = 'tls'; // Use TLS encryption
            $mail->Port = 587; // SMTP port

            // Email content
            $mail->setFrom('winniehuang9217@gmail.com', '=?UTF-8?B?' . base64_encode('Mysterious box') . '?=', true);
            // Set recipient email address
            $recipient_email = 'winniehuang9217@gmail.com';
            $mail->addAddress($recipient_email);

            $mail->Subject = '=?UTF-8?B?' . base64_encode('Feedback Received') . '?=';

            // **改动1**: 直接使用刚插入的数据来构建邮件内容，而不是查询整个数据库
            // Email body formatting
            $mailContent = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        h2 { color: #333; }
                        p { margin: 0 0 10px; }
                    </style>
                </head>
                <body>
                    <h2>Feedback Details:</h2>
                    <p><strong>Title:</strong> $title</p> <!-- 使用插入的数据 -->
                    <p><strong>Content:</strong> $content</p> <!-- 使用插入的数据 -->
                    <p><strong>Time:</strong> $time</p> <!-- 使用插入的数据 -->
                </body>
                </html>";

            // Set email content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Body = $mailContent;

            // Send email
            $mail->send();

            // Redirect to confirmation page
            echo "<script>window.location.href = 'http://localhost/SA-/SA_front_end/feedback.php';</script>";
            exit();
        } catch (Exception $e) {
            echo 'Error sending email: ' . $mail->ErrorInfo;
        }

    } else {
        // Submission failed, show an error message
        echo "Error inserting feedback: " . mysqli_error($link);
    }
}
?>
