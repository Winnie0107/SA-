<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if (isset($_GET['user']) && isset($_GET['seller']) && isset($_GET['cancel_count'])) {
    $user_id = intval($_GET['user']);
    $seller_id = intval($_GET['seller']);
    $cancel_count = intval($_GET['cancel_count']);

    $query = "INSERT INTO blacklist (buyer, seller, cancel_count) VALUES ($user_id, $seller_id, $cancel_count)";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("Error: " . mysqli_error($link));
    }

    echo "買家已加入黑名單。";
} else {
    echo "";
}

$seller_id = (int)$_SESSION['user_id'];
$query2 = "SELECT u.account, b.cancel_count 
           FROM blacklist b 
           INNER JOIN user u ON b.buyer = u.id 
           WHERE b.seller = $seller_id";

$result2 = mysqli_query($link, $query2);

if (!$result2) {
    die("Error: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>黑名單</title>
    <style>
        td {
            vertical-align: middle !important;
        }

        .page-wrapper {
            padding: 20px 0;
        }

        .clickable {
            color: black;
            text-decoration: underline;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body id="body">
    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="dashboard-wrapper user-dashboard">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>買家名稱</th>
                                    <th>取消次數</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result2)) : ?>
                                    <tr>
                                        <td><?php echo $row['account']; ?></td>
                                        <td><?php echo $row['cancel_count']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

<?php
mysqli_close($link);
?>
