<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

if (isset($_GET['store_number'])) {
    $store_number = $_GET['store_number'];

    $query = "SELECT seller_ID FROM store_info WHERE STNumber = '$store_number'";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("Error: " . mysqli_error($link));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $seller_id = $row['seller_ID'];

        $query_products = "SELECT * FROM product WHERE seller_ID = '$seller_id' AND quantity > 0";
        $result_products = mysqli_query($link, $query_products);

        if (!$result_products) {
            die("Error: " . mysqli_error($link));
        }

        // 顯示商品列表
        while ($row_product = mysqli_fetch_assoc($result_products)) {
            $product_number = $row_product['PNumber'];//盲盒編號
            echo '<div class="col-md-4">';
            echo '<div class="product-item">';
            echo '<div class="product-thumb">';
            echo '<img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($row_product['img']) . '" alt="product-img" />';
            echo '<div class="preview-meta">';
            echo '<ul>';
            echo '<li>';
            echo '<span data-toggle="modal" data-target="#product-modal' . $row_product['PNumber'] . '">';
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
            echo '<h4><a href="#">' . $row_product['PName'] . '</a></h4>';
            echo '<p class="price">' . $row_product['price'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            //modal
            echo '<div class="modal product-modal fade" id="product-modal' . $row_product['PNumber'] . '">';
            echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            echo '<i class="tf-ion-close"></i>';
            echo '</button>';
            echo '<div class="modal-dialog " role="document">';
            echo '<div class="modal-content">';
            echo '<div class="modal-body">';
            echo '<div class="row">';
            echo '<div class="col-md-8 col-sm-6 col-xs-12">';
            echo '<div class="modal-image">';
            echo '<img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($row_product['img']) . '" alt="product-img" />';
            echo '</div>';
            echo '</div>';
            echo '<div class="col-md-4 col-sm-6 col-xs-12">';
            echo '<div class="product-short-details">';
            echo '<h2 class="product-title">' . $row_product['PName'] . '</h2>';
            echo '<p class="product-price">' . $row_product['price'] . '</p>';
            echo '<p class="product-short-description">' . $row_product['details'] . '</p>';
            echo '<a href="product-single.html" class="btn btn-transparent">剩餘數量：' . $row_product['quantity'] . '</a>';
            echo '<br>';
            echo '<a href="../SA_back_end/buyer_add_to_cart.php?product_number=' . $product_number . '" class="btn btn-main">Add to cart</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        
    } else {
        echo "找不到該商店的資訊。";
    }
} else {
    echo "未提供商店編號。";
}
?>