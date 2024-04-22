<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['product_number'])) {
    $product_number = $_GET['product_number'];
    $cart_id = $_SESSION['SNumber'];

    $link = mysqli_connect('localhost', 'root', '12345678', 'box');
    if (!$link) {
        die("Error" . mysqli_connect_error());
    }

    $query = "SELECT quantity FROM product WHERE PNumber = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $product_quantity);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $total_cart_quantity = array_key_exists($product_number, $_SESSION['cart']) ? $_SESSION['cart'][$product_number] : 0;

    if ($total_cart_quantity >= $product_quantity) {
        echo "<script>alert('已經加入所有庫存'); window.location.href = 'http://localhost/SA-/SA_front_end/buyer_product.php';</script>";
        exit();
    }

    $_SESSION['cart'][$product_number] = isset($_SESSION['cart'][$product_number]) ? $_SESSION['cart'][$product_number] + 1 : 1;

    $insert_cart_item = "INSERT INTO `shopping cart item` (SNumber, PNumber, quantity) 
                         VALUES (?, ?, 1) 
                         ON DUPLICATE KEY UPDATE quantity = quantity + 1";
    $stmt = mysqli_prepare($link, $insert_cart_item);
    mysqli_stmt_bind_param($stmt, "ii", $cart_id, $product_number);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('成功加入購物車！'); window.location.href = 'http://localhost/SA-/SA_front_end/buyer_product.php';</script>";
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    echo "Error: Product number not provided!";
}

?>
