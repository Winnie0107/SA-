<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if (isset($_POST['cancel_order'])) {
    // 获取订单号
    $order_number = $_POST['order_number'];

    // 更新订单状态为 0
    $update_query = "UPDATE p_order SET state = 0 WHERE ONumber = $order_number";
    $update_result = mysqli_query($link, $update_query);

    if (!$update_result) {
        die("Error updating order: " . mysqli_error($link));
    }
}

$query = "SELECT p_order.date AS order_date, 
                p_order.total_price, 
                GROUP_CONCAT(`order item`.quantity SEPARATOR '<br>') AS quantity,
                GROUP_CONCAT(product.PName SEPARATOR '<br>') AS PName, 
                store_info.STName AS seller_name,
                p_order.state,
                p_order.ONumber
                FROM `order item`
                INNER JOIN product ON `order item`.PNumber = product.PNumber
                INNER JOIN p_order ON `order item`.ONumber = p_order.ONumber
                INNER JOIN user ON product.seller_ID = user.ID
                INNER JOIN store_info ON user.ID = store_info.seller_ID
                WHERE user.acco_level = '賣家'
                GROUP BY `order item`.ONumber, store_info.seller_ID
                ORDER BY `order item`.ONumber DESC";

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
echo '<th>店家名稱</th>';
echo '<th>訂單狀態</th>';
echo '<th>取消訂單</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$current_seller = null; // 用于跟踪当前的卖家名称

while ($row = mysqli_fetch_assoc($result)) {
    // 檢查並輸出訂單狀態
    $order_status = ($row['state'] == 1) ? '訂單已確認' : '已取消';

    if ($current_seller !== $row['seller_name']) {
        // 开始新的行
        echo '<tr>';
        echo '<td>' . $row['order_date'] . '</td>';
        echo '<td>' . $row['PName'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>$' . $row['total_price'] . '</td>';
        echo '<td>' . $row['seller_name'] . '</td>'; // 输出新的卖家名称
        $current_seller = $row['seller_name']; // 更新当前的卖家名称
        echo '<td>' . $order_status . '</td>'; // 输出订单状态
        echo '<td>';
        echo '<form method="post">';
        echo '<input type="hidden" name="order_number" value="' . $row['ONumber'] . '">';
        echo '<button type="submit" name="cancel_order" class="btn btn-danger" onclick="return confirm(\'是否確定取消此訂單？ (提醒：隨意取消訂單賣家可將您新增至黑名單)\')">取消</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>'; // 结束当前店家的行
    }
}

echo '</tbody>';
echo '</table>';


mysqli_close($link);
?>