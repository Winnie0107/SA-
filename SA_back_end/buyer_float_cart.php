<?php
session_start();

if (!isset($_SESSION['totalPrice'])) {
    $_SESSION['totalPrice'] = 0; 
}

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

$cart_id = $_SESSION['SNumber'];
$totalPrice = 0; 

$query = "SELECT product.*, `shopping cart item`.quantity FROM product 
          INNER JOIN `shopping cart item` ON product.PNumber = `shopping cart item`.PNumber
          WHERE `shopping cart item`.SNumber = $cart_id";

$result = mysqli_query($link, $query);

if (!$result) {
    die("Error: " . mysqli_error($link));
}

$cartItems = [];
$itemCount = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $priceWithoutSymbol = (float) str_replace('$', '', $row['price']);
    $itemPrice = $priceWithoutSymbol * $row['quantity']; 
    $totalPrice += $itemPrice; // 累加商品的價格

    $PNumber = $row['PNumber'];
    if (!isset($cartItems[$PNumber])) {
        $cartItems[$PNumber] = $row;
        $itemCount++;
    } else {
        $cartItems[$PNumber]['quantity'] += $row['quantity'];
        $cartItems[$PNumber]['price'] = '$' . ($priceWithoutSymbol + (float) str_replace('$', '', $cartItems[$PNumber]['price']));
    }
}

//數量限制
$i = 0;
foreach ($cartItems as $item) {
    if ($i < 3) {
        echo "<div class='media product-card'>";
        echo "<a class='pull-left' href='product-single.html'>";
        echo "<img width='80' src='data:image/jpeg;base64," . base64_encode($item['img']) . "' alt='' />";
        echo "</a>";
        echo "<div class='media-body'>";
        echo "<h4 class='media-heading'><a href='product-single.html'>" . $item['PName'] . "</a></h4>";
        echo "<p class='price'>" . $item['quantity'] . " x " . $item['price'] . "</p>";
        echo "<form action='../SA_back_end/delete_cart_item.php' method='POST'>";
        echo "<input type='hidden' name='item_id' value='" . $item['SINumber'] . "' />";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        $i++;
    }
}

if ($itemCount > 3) {
    echo "<div class='media'>";
    echo "<div class='media-body text-center'>";
    echo "<div class='cart-price'>";
    echo "<span>view more in cart</span>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

if ($itemCount == 0) {
    $_SESSION['totalPrice'] = 0; 
    echo "<div class='media'>";
    echo "<div class='media-body text-center'>";
    echo "<div class='cart-price'>";
    echo "<span>The cart is empty</span>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

echo "<div class='cart-summary'>";
echo "<span>Total</span>";
echo "<span class='total-price'>$" . $totalPrice . "</span>";
echo "</div>";

// 更新 $_SESSION['totalPrice']
$_SESSION['totalPrice'] = $totalPrice;

mysqli_close($link);
?>
