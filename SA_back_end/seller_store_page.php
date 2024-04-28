<?php
session_start();

$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

$query = "SELECT * FROM store_info WHERE seller_ID = '$user_id'";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Error: " . mysqli_error($link));
}

// 商店資訊
while ($row = mysqli_fetch_assoc($result)) {
    echo '<section class="single-product">';
    echo '<div class="container">';
    echo '<div class="row mt-20">';
    echo '<div class="col-md-5">';
    echo '<img class="img-set" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="product-img" />';
    echo '</div>';
    echo '<div class="col-md-7">';
    echo '<div class="single-product-details">';
    echo '<h2>' . $row['STName'] . '</h2>';
    echo '<br>';
    echo '<p class="product-description mt-20">' . $row['details'] . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</section>';
}
?>
