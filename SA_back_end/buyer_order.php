<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

$query = "SELECT p_order.date AS order_date, 
                p_order.total_price, 
                GROUP_CONCAT(`order item`.quantity SEPARATOR '<br>') AS quantity,
                GROUP_CONCAT(product.PName SEPARATOR '<br>') AS PName, 
                user.account AS seller_account,
                p_order.state
                FROM `order item`
                INNER JOIN product ON `order item`.PNumber = product.PNumber
                INNER JOIN p_order ON `order item`.ONumber = p_order.ONumber
                INNER JOIN user ON product.seller_ID = user.ID
                WHERE user.acco_level = '賣家'
                GROUP BY `order item`.ONumber, product.seller_ID
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
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$current_seller = null; // 用于跟踪当前的卖家名称

while ($row = mysqli_fetch_assoc($result)) {
    if ($current_seller !== $row['seller_account']) {
        // 如果当前店家名称不同于上一个店家名称，则创建新行
        if ($current_seller !== null) {
            echo '</td>'; // 结束上一个卖家名称的单元格
            // 输出订单状态
            echo '<td>';
            if ($row['state'] == 1) {
                echo '賣家已確認';
            } else {
                echo '未確認';
            }
            echo '</td>';
            echo '</tr>'; // 结束上一行
        }
        // 开始新的行
        echo '<tr>';
        echo '<td>' . $row['order_date'] . '</td>';
        echo '<td>' . $row['PName'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>$' . $row['total_price'] . '</td>';
        echo '<td>' . $row['seller_account'] . '</td>'; // 输出新的卖家名称
        $current_seller = $row['seller_account']; // 更新当前的卖家名称
    }
}

// 输出最后一个卖家的订单状态
echo '<td>';
if ($row['state'] == 1) {
    echo '賣家已確認';
} else {
    echo '未確認';
}
echo '</td>';
echo '</tr>'; // 结束最后一个店家的行

echo '</tbody>';
echo '</table>';

mysqli_close($link);
?>
