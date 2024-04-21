<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $PName = isset($_POST['PName']) ? mysqli_real_escape_string($link, $_POST['PName']) : '';
    $category = isset($_POST['category']) ? mysqli_real_escape_string($link, $_POST['category']) : '';
    $price = isset($_POST['price']) ? mysqli_real_escape_string($link, $_POST['price']) : '';
    $details = isset($_POST['details']) ? mysqli_real_escape_string($link, $_POST['details']) : '';
    $quantity = isset($_POST['quantity']) ? mysqli_real_escape_string($link, $_POST['quantity']) : '';
    $selled = $quantity > 0 ? 1 : 0;

    $form_data = isset($_FILES['img']['tmp_name']) ? $_FILES['img']['tmp_name'] : '';

    $data = addslashes(file_get_contents($form_data));

    $result = mysqli_query($link, "INSERT INTO product (seller_ID, PName, category, price, details, quantity, img, selled) 
        VALUES ('$user_id', '$PName', '$category', '$price', '$details', '$quantity', '$data', '$selled')");


    if ($result) {
        echo "<script>window.location.href = 'http://localhost/SA-/SA_front_end/seller_confirmation.php';</script>";
        exit();
    } else {
        echo "新增失敗，請重試";
    }
}
?>
