<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complete_order'])) {
    $order_number = $_POST['order_number'];

    $query = "UPDATE p_order SET pick = 1 WHERE ONumber = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 's', $order_number);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('取貨完成');</script>";
    } else {
        echo "<script>alert('更新失敗：" . mysqli_error($link) . "');</script>";
    }

    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get_order_status'])) {
    $order_number = $_GET['order_number'];
    $query = "SELECT state, ship, pick FROM p_order WHERE ONumber = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 's', $order_number);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $state, $ship, $pick);
        mysqli_stmt_fetch($stmt);
        echo json_encode(['state' => $state, 'ship' => $ship, 'pick' => $pick]);
    } else {
        echo json_encode(['error' => '查詢失敗: ' . mysqli_error($link)]);
    }

    mysqli_stmt_close($stmt);
    exit();
}

$query = "SELECT p_order.date AS order_date, p_order.total_price, 
          GROUP_CONCAT(`order item`.quantity SEPARATOR '<br>') AS quantity, 
          GROUP_CONCAT(product.PName SEPARATOR '<br>') AS PName, 
          store_info.STName AS seller_name, p_order.state, p_order.ONumber, 
          p_order.ship, p_order.pick 
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
echo '<th>操作</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$current_seller = null;

while ($row = mysqli_fetch_assoc($result)) {
    $order_status = ($row['state'] >= 1) ? '訂單已確認' : '已取消';

    if ($current_seller !== $row['seller_name']) {
        echo '<tr>';
        echo '<td>' . $row['order_date'] . '</td>';
        echo '<td>' . $row['PName'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>$' . $row['total_price'] . '</td>';
        echo '<td>' . $row['seller_name'] . '</td>';
        $current_seller = $row['seller_name'];
        echo '<td>';
        if ($row['state'] >= 1) {
            echo '<a href="#" class="order-status-link" data-toggle="modal" data-target="#orderStatusModal" data-order-number="' . $row['ONumber'] . '" style="color: blue;">查看訂單狀態</a>';
        } else {
            echo '<span style="color: red;">已取消</span>';
        }
        echo '</td>';
        echo '<td>';
        echo '<form method="post">';
        echo '<input type="hidden" name="order_number" value="' . $row['ONumber'] . '">';
        if ($row['ship'] == 1 && $row['pick'] == 1) {
            echo '<span>訂單已完成</span>';
        } elseif ($row['ship'] >= 1 && $row['pick'] != 1) {
            echo '<button type="submit" name="complete_order" class="btn btn-success">取貨完成</button>';
        } else {
            echo '<button type="button" class="btn btn-danger cancel-order-btn" data-toggle="modal" data-target="#cancelOrderModal" data-order-number="' . $row['ONumber'] . '">取消</button>';
        }
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
}

echo '</tbody>';
echo '</table>';
mysqli_close($link);
?>
