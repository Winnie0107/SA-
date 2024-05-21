<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php'; // Include PHPMailer

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

    $mail->Subject = '=?UTF-8?B?' . base64_encode('Feedback Received') . '?';



    // Fetch feedback details from the feedback table
    // Modify the SQL query based on your database schema
    $query = "SELECT title, content, time FROM feedback WHERE user_id = $user_id";
    $query_result = mysqli_query($link, $query)

    $items = [];
    while ($row = mysqli_fetch_assoc($query_result)) {
        $items[] = [
            'title'=>$row['title'],
            'content'=>$row['content'],
            'time'=>$row['time'],

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
            <h2>Feedback Details:</h2>
            <p>Title: {$items['title']}</p>
            <p>Content: {$items['content']}</p>
            <p>Time: {$items['time']}</p>
        </body>
        </html>
    ";

    // Set email content
    $mail->Body = $mailContent;

    // Send email
    $mail->send();

    // Redirect to confirmation page
    echo "<script>window.location.href = 'http://localhost/SA-/SA_front_end/feedback.php';</script>";
    exit();
} catch (Exception $e) {
    echo 'Error sending email: ' . $mail->ErrorInfo;
}
?>