<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = mysqli_connect('localhost:3307', 'root', '12345678', 'box');

    $account = isset($_POST['account']) ? mysqli_real_escape_string($link, $_POST['account']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($link, $_POST['password']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($link, $_POST['email']) : '';
    $level = isset($_POST['level']) ? mysqli_real_escape_string($link, $_POST['level']) : '';

    $sql = "INSERT INTO user (account, password, email, level) VALUES ('$account', '$password', '$email', '$level')";

    if (mysqli_query($link, $sql)) {
        echo "<script>alert('註冊成功！'); window.location.href = 'http://localhost/SA-/login.html';</script>";
        exit();
    } 
    else {
        echo "錯誤: " . $sql . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>