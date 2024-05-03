<?php
session_start();

$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

$query = "SELECT * FROM product WHERE seller_ID = '$user_id' AND quantity > 0";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Error: " . mysqli_error($link));
}

// 商品列表
while ($row = mysqli_fetch_assoc($result)) {
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