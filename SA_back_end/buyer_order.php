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
                GROUP BY `order item`.ONumber
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

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['order_date'] . '</td>';
    echo '<td>' . $row['PName'] . '</td>';
    echo '<td>' . $row['quantity'] . '</td>';
    echo '<td>$' . $row['total_price'] . '</td>';
    echo '<td>' . $row['seller_account'] . '</td>';
    // 添加订单状态列，并根据订单状态显示不同内容
    echo '<td>';
    if ($row['state'] == 1) {
        echo '賣家已確認';
    } else {
        echo '未確認';
    }
    echo '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

mysqli_close($link);
?>
