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
    echo '<li role="presentation" class="' . $class . '"><a href="#' . str_replace(' ', '', $category) . '" aria-controls="' . str_replace(' ', '', $category) . '" role="tab" data-toggle="tab">' . $category . '</a></li>';
}
echo '</ul>';

// 分頁內容
echo '<div class="tab-content">';
foreach ($all_categories as $index => $category) {
    $class = ($index == 0) ? 'active' : '';
    echo '<div role="tabpanel" class="tab-pane ' . $class . '" id="' . str_replace(' ', '', $category) . '">';
    echo '<div class="row mt-40">'; // 將這行移到此處
    if ($category == '全部') {
        $query = "SELECT * FROM product WHERE seller_ID = '$user_id' AND quantity > 0";
    } else {
        $query = "SELECT * FROM product WHERE seller_ID = '$user_id' AND category='$category' AND quantity > 0";
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
            echo '<a href="seller_edit_product.php?PNumber=' . $row['PNumber'] . '"><i class="glyphicon glyphicon-pencil"></i></a>';
            echo '</li>';
            echo '<li>';
            echo '<a href="#" onclick="deleteProduct(' . $row['PNumber'] . ')">';
            echo '<i class="glyphicon glyphicon-minus"></i>';
            echo '</a>';
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

<script>
    function deleteProduct(PNumber) {
        if (confirm("確定要刪除此商品嗎？")) {
            $.ajax({
                type: "POST",
                url: "../SA_back_end/delete_product.php",
                data: { PNumber: PNumber },
                success: function(response) {
                    alert("商品已成功刪除！");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("刪除商品時發生錯誤：" + error);
                }
            });
        }
    }
</script>
