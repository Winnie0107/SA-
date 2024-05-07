<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $buyer_ID = $_SESSION['user_id'];
    $phone_number = mysqli_real_escape_string($link, $_POST['phonenumber']);
    $line_id = mysqli_real_escape_string($link, $_POST['line_id']);
    $date = date("Y-m-d");
    $state = 1;

    // 初始化訂單詳細信息
    $_SESSION['order_details'] = [];

    // 用於存儲不同賣家的訂單編號和總價
    $order_numbers = [];

    // 從 shopping cart item 表中獲取購物車內容
    $select_cart_items_query = "SELECT * FROM `shopping cart item` WHERE SNumber = {$_SESSION['SNumber']}";
    $cart_items_result = mysqli_query($link, $select_cart_items_query);

    if (!$cart_items_result) {
        die("Error fetching cart items: " . mysqli_error($link));
    }

    // 插入訂單
    while ($row = mysqli_fetch_assoc($cart_items_result)) {
        $PNumber = $row['PNumber'];
        $quantity = $row['quantity'];
        $user_account = mysqli_real_escape_string($link, $_POST['account']);

        // 獲取商品價格
        $get_product_price_query = "SELECT price FROM product WHERE PNumber = '$PNumber'";
        $product_price_result = mysqli_query($link, $get_product_price_query);
        $product_price_row = mysqli_fetch_assoc($product_price_result);
        $product_price = $product_price_row['price'];
        mysqli_free_result($product_price_result);

        $product_price = str_replace('$', '', $product_price);

        // 計算訂單價格
        $order_price = $product_price * $quantity;
        $get_seller_query = "SELECT seller_ID FROM product WHERE PNumber = '$PNumber'";
        $seller_result = mysqli_query($link, $get_seller_query);
        $seller_row = mysqli_fetch_assoc($seller_result);
        $seller_ID = $seller_row['seller_ID'];

        if (!isset($order_numbers[$seller_ID])) {
            // 如果是新的賣家，則插入新的訂單
            $insert_order_query = "INSERT INTO p_order (buyer_ID, total_price, date, phone_number, lineID, state) 
                                   VALUES ('$buyer_ID', '$order_price', '$date', '$phone_number', '$line_id', '$state')";
            mysqli_query($link, $insert_order_query);
            $order_numbers[$seller_ID]['ONumber'] = mysqli_insert_id($link);
            $order_numbers[$seller_ID]['total_price'] = $order_price;
        } else {
            // 如果是同一個賣家，則將訂單的價格加到已存在的訂單中
            $order_numbers[$seller_ID]['total_price'] += $order_price;
            $update_order_price_query = "UPDATE p_order SET total_price = '{$order_numbers[$seller_ID]['total_price']}' WHERE ONumber = '{$order_numbers[$seller_ID]['ONumber']}'";
            mysqli_query($link, $update_order_price_query);
        }

        $ONumber = $order_numbers[$seller_ID]['ONumber'];
        $insert_order_item_query = "INSERT INTO `order item` (ONumber, PNumber, quantity) 
                                    VALUES ('$ONumber', '$PNumber', '$quantity')";
        $result = mysqli_query($link, $insert_order_item_query);
        if (!$result) {
            echo "Error inserting into order item: " . mysqli_error($link);
        }

        // 獲取商品名稱for email
        $get_product_name_query = "SELECT PName FROM product WHERE PNumber = '$PNumber'";
        $product_name_result = mysqli_query($link, $get_product_name_query);
        $product_name_row = mysqli_fetch_assoc($product_name_result);
        $product_name = $product_name_row['PName'];
        mysqli_free_result($product_name_result);

        // 獲取賣家名稱for email
        $get_seller_name_query = "SELECT store_info.STName FROM store_info INNER JOIN user ON store_info.seller_ID = user.ID WHERE user.ID = '$seller_ID'";
        $seller_name_result = mysqli_query($link, $get_seller_name_query);
        $seller_name_row = mysqli_fetch_assoc($seller_name_result);
        $seller_name = $seller_name_row['STName'];
        mysqli_free_result($seller_name_result);

        // 獲取賣家 email
        $get_seller_email_query = "SELECT email FROM user WHERE ID = '$seller_ID'";
        $seller_email_result = mysqli_query($link, $get_seller_email_query);
        $seller_email_row = mysqli_fetch_assoc($seller_email_result);
        $seller_email = $seller_email_row['email'];

        $_SESSION['seller_email'][$seller_ID] = $seller_email;


        //email顯示資料
        $_SESSION['order_details'][$seller_ID][] = [
            'user_name' => $user_account, // 用戶名稱
            'user_email' => $_SESSION['user_email'], //用戶mail
            'product_name' => $product_name, // 產品名稱
            'quantity' => $quantity, // 數量
            'order_price' => $order_price, // 訂單價格
            'order_date' => $date, // 下單日期
            'seller_name' => $seller_name // 賣家名稱
        ];

        // 減去被下單商品數量
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

    // 清空購物車內容
    $delete_cart_items_query = "DELETE FROM `shopping cart item` WHERE SNumber = {$_SESSION['SNumber']}";
    mysqli_query($link, $delete_cart_items_query);

    $_SESSION['cart'] = []; // 清空購物車內容

    // 跳轉到寄email後端

    header("Location: mail_order.php");
    exit();
}

?>