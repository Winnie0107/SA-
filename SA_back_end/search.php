<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

if (isset($_POST['search'])) {
    $keyword = isset($_POST['keyword']) ? mysqli_real_escape_string($link, $_POST['keyword']) : '';

    $query = "SELECT * FROM product WHERE quantity > 0 AND (PName LIKE '%$keyword%' OR details LIKE '%$keyword%') ORDER BY PNumber DESC LIMIT 6";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("Error: " . mysqli_error($link));
    }
    echo '<div class="row mt-20">';

    while ($row = mysqli_fetch_assoc($result)) {
        $product_number = $row['PNumber']; //盲盒編號

        echo '<div class="col-md-4">';
        echo '<div class="product-item">';
        echo '<div class="product-thumb">';
        echo '<img class="img-set" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="product-img" />';
        echo '<div class="preview-meta">';
        echo '<ul>';
        echo '<li>';
        echo '<span data-toggle="modal" data-target="#product-modal' . $row['PNumber'] . '">';
        echo '<i class="tf-ion-ios-search-strong"></i>';
        echo '</span>';
        echo '</li>';
        echo '<li>';
        echo '<a href="../SA_back_end/buyer_add_to_cart.php?product_number=' . $product_number . '"><i class="tf-ion-android-cart"></i></a>';
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
        echo '<form action="../SA_back_end/buyer_add_to_cart.php" method="post">';
        echo '<input type="hidden" name="product_number" value="' . $row['PNumber'] . '">';
        echo '<a href="../SA_back_end/buyer_add_to_cart.php?product_number=' . $product_number . '" class="btn btn-main">Add to cart</a>';
        echo '</form>';

        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>