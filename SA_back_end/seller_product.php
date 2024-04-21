<?php
session_start();

$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

$query = "SELECT * FROM product WHERE seller_ID = '$user_id'";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Error: " . mysqli_error($link));
}

// 商品列表
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="col-md-4">';
    echo '<div class="product-item">';
    echo '<div class="product-thumb">';
    echo '<img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="product-img" />';
    echo '<div class="preview-meta">';
    echo '<ul>';
    echo '<li>';
    echo '<span data-toggle="modal" data-target="#product-modal' . $row['PNumber'] . '">';
    echo '<i class="glyphicon glyphicon-pencil"></i>';
    echo '</span>';
    echo '</li>';
    echo '<li>';
    echo '<a href="#"><i class="glyphicon glyphicon-minus"></i></a>';
    echo '</li>';
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '<div class="product-content">';
    echo '<h4><a href="#">' . $row['PName'] . '</a></h4>';
    echo '<p class="price">' . $row['price'] . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    //modal
    echo '<div class="modal product-modal fade" id="product-modal' . $row['PNumber'] . '">';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<i class="tf-ion-close"></i>';
    echo '</button>';
    echo '<div class="modal-dialog " role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-body">';
    echo '<div class="row">';
    echo '<div class="col-md-8 col-sm-6 col-xs-12">';
    echo '<div class="modal-image">';
    echo '<img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="product-img" />';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-md-4 col-sm-6 col-xs-12">';
    echo '<div class="product-short-details">';
    echo '<h2 class="product-title">' . $row['PName'] . '</h2>';
    echo '<p class="product-price">' . $row['price'] . '</p>';
    echo '<p class="product-short-description">' . $row['details'] . '</p>';
    echo '<a href="product-single.html" class="btn btn-transparent">剩餘數量：' . $row['quantity'] . '</a>';
    echo '<br>';
    echo '<a href="cart.html" class="btn btn-main">修改內容</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>
