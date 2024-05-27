<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$link = mysqli_connect('localhost', 'root', '12345678', 'box');
if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'], $_POST['reviewID'], $_POST['replyContent'])) {
        $reviewID = intval($_POST['reviewID']);
        $replyContent = htmlspecialchars($_POST['replyContent'], ENT_QUOTES, 'UTF-8');
        $seller_id = $_SESSION['user_id'];

        $reply_query = "INSERT INTO reply (ReviewID, ReplyContent, ReplyTime) VALUES (?, ?, NOW())";
        $reply_stmt = mysqli_prepare($link, $reply_query);
        if (!$reply_stmt) {
            die("準備插入回覆失敗: " . mysqli_error($link));
        }
        mysqli_stmt_bind_param($reply_stmt, "is", $reviewID, $replyContent);
        if (!mysqli_stmt_execute($reply_stmt)) {
            die("插入回覆失敗: " . mysqli_stmt_error($reply_stmt));
        }



        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        die("提交的資料不完整。");
    }
} else {
    die("無效的請求方法。");
}

mysqli_close($link);
?>
