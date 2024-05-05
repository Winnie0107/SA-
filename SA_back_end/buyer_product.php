<?php
session_start();

$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("連接錯誤：" . mysqli_connect_error());
}

// 定義所有可能的分類
$all_categories = ['全部', '公仔', '首飾', '實用小物', '服飾']; 

echo '<ul class="nav nav-tabs nav-justified" role="tablist">';
foreach ($all_categories as $index => $category) {
    $class = ($index == 0) ? 'active' : '';
    echo '<li role="presentation" class="' . $class . '"><a href="#' . $category . '" aria-controls="' . $category . '" role="tab" data-toggle="tab">' . $category . '</a></li>';
}
echo '</ul>';

// 分頁內容
echo '<div class="tab-content">';
foreach ($all_categories as $index => $category) {
    $class = ($index == 0) ? 'active' : '';
    echo '<div role="tabpanel" class="tab-pane ' . $class . '" id="' . $category . '">';
    echo '<div class="row mt-40">'; // 將這行移到此處
    if ($category == '全部') {
        $query = "SELECT * FROM product WHERE quantity > 0";
    } else {
        $query = "SELECT * FROM product WHERE category='$category' AND quantity > 0";
    }
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("錯誤：" . mysqli_error($link));
    }

    // 檢查是否有商品
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
        // 有商品，顯示商品列表
        while ($row = mysqli_fetch_assoc($result)) {
            $product_number = $row['PNumber'];//盲盒編號
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
        // 沒有商品，顯示提示訊息
        echo '<div class="col-md-12">';
        echo '<p class="text-center">暫無商品</p>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}
echo '</div>';
?>
