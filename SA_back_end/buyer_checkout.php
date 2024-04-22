<?php
session_start();

if (mysqli_num_rows($result) == 0) {
    echo "購物車內沒有商品";
} else {
    $totalPrice = 0;
    $cartItems = [];

    while ($row = mysqli_fetch_assoc($result)) {

        $priceWithoutSymbol = (float) str_replace('$', '', $row['price']);

        $PNumber = $row['PNumber'];
        if (!isset($cartItems[$PNumber])) {
            $cartItems[$PNumber] = $row;
        } else {
            $cartItems[$PNumber]['quantity'] += $row['quantity'];
            $cartItems[$PNumber]['price'] = '$' . ($priceWithoutSymbol + (float) str_replace('$', '', $cartItems[$PNumber]['price']));
        }

        // 修改这里的表单动作属性值
        echo "<form action='delete_cart_item.php' method='POST'>";
        echo "<div class='media product-card'>";
        echo "<a class='pull-left' href='product-single.html'>";
        echo "<img width='80' src='data:image/jpeg;base64," . base64_encode($row['img']) . "' alt='' />";
        echo "</a>";
        echo "<div class='media-body'>";
        echo "<h4 class='media-heading'><a href='product-single.html'>" . $row['PName'] . "</a></h4>";
        echo "<p class='price'>" . $row['quantity'] . " x " . $row['price'] . "</p>";
        echo "<input type='hidden' name='item_id' value='" . $row['SINumber'] . "' />";
        echo "<button type='submit' class='remove' style='color: red;'>移除</button>";
        echo "</div>";
        echo "</div>";
        echo "</form>";

        $itemPrice = $priceWithoutSymbol * $row['quantity'];
        $totalPrice += $itemPrice;
    }
    $_SESSION['totalPrice'] = $totalPrice;
}
?>


