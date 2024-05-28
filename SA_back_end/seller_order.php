<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if(isset($_POST['cancel_order'])) {
    $order_number = $_POST['order_number'];
    
    $update_query = "UPDATE p_order SET state = 0 WHERE ONumber = $order_number";
    $update_result = mysqli_query($link, $update_query);

    if (!$update_result) {
        die("更新訂單時出錯: " . mysqli_error($link));
    }
}

if(isset($_POST['ship_order'])) {
    $order_number = $_POST['order_number'];
    
    $update_query = "UPDATE p_order SET ship = 1 WHERE ONumber = '$order_number'";
    
    if (mysqli_query($link, $update_query)) {
        echo '<span>訂單已成功出貨！<a href="http://localhost/SA-/SA_front_end/seller_order.php">點我回到訂單頁面</a></span>';
    } else {
        echo "出貨操作失敗：" . mysqli_error($link);
    }
}

$query = "SELECT p_order.ONumber, 
                p_order.date AS order_date, 
                p_order.total_price, 
                p_order.phone_number, 
                p_order.payment, 
                p_order.shipping_store,
                p_order.state,
                p_order.ship, 
                GROUP_CONCAT(`order item`.quantity SEPARATOR '<br>') AS quantity,
                GROUP_CONCAT(product.PName SEPARATOR '<br>') AS PName, 
                user.account
                FROM `order item`
                INNER JOIN product ON `order item`.PNumber = product.PNumber
                INNER JOIN p_order ON `order item`.ONumber = p_order.ONumber
                INNER JOIN user ON p_order.buyer_ID = user.ID
                WHERE product.seller_ID = '$user_id'
                GROUP BY `order item`.ONumber
                ORDER BY `order item`.ONumber DESC
                ";
$result = mysqli_query($link, $query);

if (!$result) {
    die("查詢訂單時出錯: " . mysqli_error($link));
}

echo '<table class="table">';
echo '<thead>';
echo '<tr>';
echo '<th>訂單日期</th>';
echo '<th>商品名稱</th>';
echo '<th>數量</th>';
echo '<th>總價</th>';
echo '<th>用戶名稱</th>';
echo '<th>電話號碼</th>';
echo '<th>取貨門市</th>';
echo '<th>付款狀態</th>';
echo '<th>操作</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['order_date'] . '</td>';
    echo '<td>' . $row['PName'] . '</td>';
    echo '<td>' . $row['quantity'] . '</td>';
    echo '<td>$' . $row['total_price'] . '</td>';
    echo '<td>' . $row['account'] . '</td>';
    echo '<td>' . $row['phone_number'] . '</td>';
    echo '<td>' . $row['shipping_store'] . '</td>';
    echo '<td>';
    echo ($row['payment'] == 1) ? '已付款' : '貨到付款'; // 顯示付款狀態
    echo '</td>';
    
    echo '<td>';
    if ($row['ship'] == 1) {
        echo '<a href="#" class="order-status-link" data-toggle="modal" data-target="#orderStatusModal" data-order-number="' . $row['ONumber'] . '" style="color: blue;">查看訂單狀態</a>';
    } elseif ($row['state'] >= 1) {
        echo '<form method="post" style="display: flex; align-items: center;">';
        echo '<input type="hidden" name="order_number" value="' . $row['ONumber'] . '">';
        echo '<button type="submit" name="ship_order" class="btn btn-success" onclick="return confirm(\'是否確定已寄出商品？ \')">出貨</button>';
        echo '<input type="hidden" name="order_number" value="' . $row['ONumber'] . '">';
        echo '<button type="button" class="btn btn-danger cancel-order-btn" data-toggle="modal" data-target="#cancelOrderModal" data-order-number="' . $row['ONumber'] . '">取消</button>';        echo '</form>';
    } else {
        echo '<span style="color: red;">已取消</span>';
    }
    echo '</td>';
    
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

mysqli_close($link);
?>

