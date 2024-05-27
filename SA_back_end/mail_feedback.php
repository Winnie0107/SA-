<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php'; // Include PHPMailer

// Database connection and user ID
$link = mysqli_connect('localhost', 'root', '12345678', 'box');
if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}
session_start();
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

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

    // Fetch feedback details from the feedback table
    // Modify the SQL query based on your database schema
    $query = "SELECT title, content, time FROM feedback WHERE user_id = $user_id";
    $query_result = mysqli_query($link, $query);

    if (!$query_result) {
        throw new Exception('Query failed: ' . mysqli_error($link));
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($query_result)) {
        $items[] = [
            'title' => $row['title'],
            'content' => $row['content'],
            'time' => $row['time'],
        ];
    }

    // Email body formatting
    $mailContent = "
        <html>
        <head>
            <style>
                /* Email styling */
            </style>
        </head>
        <body>
            <h2>Feedback Details:</h2>";
    
    foreach ($items as $item) {
        $mailContent .= "
            <p><strong>Title:</strong> {$item['title']}</p>
            <p><strong>Content:</strong> {$item['content']}</p>
            <p><strong>Time:</strong> {$item['time']}</p>
            <hr>";
    }
    
    $mailContent .= "
        </body>
        </html>
    ";

    // Set email content
    $mail->Body = $mailContent;
    $mail->isHTML(true); // Set email format to HTML

    // Send email
    $mail->send();

    // Redirect to confirmation page
    echo "<script>window.location.href = 'http://localhost/SA-/SA_front_end/feedback.php';</script>";
    exit();
} catch (Exception $e) {
    echo 'Error sending email: ' . $mail->ErrorInfo;
}
?>
