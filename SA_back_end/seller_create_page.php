<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $STName = isset($_POST['STName']) ? mysqli_real_escape_string($link, $_POST['STName']) : '';
    $details = isset($_POST['details']) ? mysqli_real_escape_string($link, $_POST['details']) : '';

    $form_data = isset($_FILES['img']['tmp_name']) ? $_FILES['img']['tmp_name'] : '';

    $data = addslashes(file_get_contents($form_data));

    $result = mysqli_query($link, "INSERT INTO store_info (seller_ID, STName, details, img) 
        VALUES ('$user_id', '$STName', '$details', '$data')");


    if ($result) {
        echo "<script>window.location.href = 'http://localhost/SA-/SA_front_end/seller_store_page.php';</script>";
        exit();
    } else {
        echo "新增失敗，請重試";
    }
}
?>
