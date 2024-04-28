<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if(isset($_POST['cancel_order'])) {
    // 获取订单号
    $order_number = $_POST['order_number'];
    
    // 更新订单状态为 0
    $update_query = "UPDATE p_order SET state = 0 WHERE ONumber = $order_number";
    $update_result = mysqli_query($link, $update_query);

    if (!$update_result) {
        die("Error updating order: " . mysqli_error($link));
    }
}

$query = "SELECT p_order.ONumber, 
                p_order.date AS order_date, 
                p_order.total_price, 
                p_order.phone_number, 
                p_order.lineID, 
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
    die("Error: " . mysqli_error($link));
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
echo '<th>LINE ID</th>';
echo '<th>取消訂單</th>';
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
    echo '<td>' . $row['lineID'] . '</td>';
    // 添加取消订单按钮，并包含订单号
    echo '<td>';
    echo '<form method="post">';
    echo '<input type="hidden" name="order_number" value="' . $row['ONumber'] . '">';
    echo '<button type="submit" name="cancel_order" onclick="return confirm(\'是否確定取消此訂單？\')">取消</button>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

mysqli_close($link);
?>
