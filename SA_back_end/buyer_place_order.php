<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cart_contents = $_SESSION['cart'];

    $buyer_ID = $_SESSION['user_id'];
    $total_price = $_SESSION['totalPrice'];
    $phone_number = mysqli_real_escape_string($link, $_POST['phonenumber']);
    $line_id = mysqli_real_escape_string($link, $_POST['line_id']);
    $date = date("Y-m-d");
    $state = 1;

    //p_order
    $insert_order_query = "INSERT INTO p_order (buyer_ID, total_price, date, phone_number, lineID, state) 
                            VALUES ('$buyer_ID', '$total_price', '$date', '$phone_number', '$line_id', '$state')";
    mysqli_query($link, $insert_order_query);

    $ONumber = mysqli_insert_id($link);

    //order item
    foreach ($cart_contents as $PNumber => $quantity) {
        $insert_order_item_query = "INSERT INTO `order item` (ONumber, PNumber, quantity) 
                                    VALUES ('$ONumber', '$PNumber', '$quantity')";
        $result = mysqli_query($link, $insert_order_item_query);
        if (!$result) {
            echo "Error inserting into order_item: " . mysqli_error($link);
        }
    }

    //減掉被下單的
    foreach ($cart_contents as $PNumber => $quantity) {
        $get_product_quantity_query = "SELECT quantity FROM product WHERE PNumber = '$PNumber'";
        $result = mysqli_query($link, $get_product_quantity_query);
        $row = mysqli_fetch_assoc($result);
        $product_quantity = $row['quantity'];
        mysqli_free_result($result);

        $updated_product_quantity = $product_quantity - $quantity;

        $update_product_quantity_query = "UPDATE product SET quantity = '$updated_product_quantity' WHERE PNumber = '$PNumber'";
        $result = mysqli_query($link, $update_product_quantity_query);
        if (!$result) {
            echo "Error updating product quantity: " . mysqli_error($link);
        }
    }

    $delete_cart_items_query = "DELETE FROM `shopping cart item` WHERE SNumber = {$_SESSION['SNumber']}";
    mysqli_query($link, $delete_cart_items_query);

    $_SESSION['cart'] = [];
    $_SESSION['totalPrice'] = 0;

    echo "<script>window.location.href = 'http://localhost/SA-/SA_front_end/buyer_confirmation.php';</script>";
    exit();
}

?>