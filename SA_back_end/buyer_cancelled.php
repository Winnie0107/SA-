<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 查詢用戶名稱和取消次數，只顯示取消次數不為零的買家
$query = "
    SELECT u.id as buyer_id, u.account AS account, 
           IFNULL(COUNT(p_order.ONumber), 0) AS cancel_count
    FROM user u
    LEFT JOIN p_order ON u.ID = p_order.buyer_ID AND p_order.state = 0
    LEFT JOIN `order item` oi ON p_order.ONumber = oi.ONumber
    LEFT JOIN product p ON oi.PNumber = p.PNumber
    WHERE u.acco_level = 0 
    AND u.ID NOT IN (SELECT buyer FROM blacklist WHERE seller = $user_id)
    AND p.seller_ID = $user_id
    GROUP BY u.account
    HAVING cancel_count > 0
";

$result = mysqli_query($link, $query);

if (!$result) {
    die("Error: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="zh-TW">

<body id="body">
    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>買家名稱</th>
                                <th>取消次數</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?php echo $row['account']; ?></td>
                                    <td><?php echo $row['cancel_count']; ?></td>
                                    <td>
                                        <a href="cancelled_detail.php?user_id=<?php echo $row['buyer_id']; ?>" class="btn btn-details">訂單明細</a>
                                        <button class="btn btn-blacklist" onclick="addToBlacklist('<?php echo $row['buyer_id']; ?>', '<?php echo $row['cancel_count']; ?>')">加入黑名單</button>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

    <script>
        function showOrderDetails(user_id) {
            // 將用戶名稱參數 account 傳遞到 cancelled_detail.php
            location.href = "cancelled_detail.php?user=" + user_id;
        }


        function showConfirmation(user_id) {
            var modal = document.getElementById("confirmationModal");
            modal.style.display = "block";
            // 将用户信息传递给addToBlacklist函数
            modal.dataset.user_id = user_id;
        }

        function hideConfirmation() {
            var modal = document.getElementById("confirmationModal");
            modal.style.display = "none";
        }

        function addToBlacklist(buyer_id, cancel_count) {
            var modal = document.getElementById("confirmationModal");
            var user_id = modal.dataset.account;
            // 将用户信息传递到blacklist.php页面
            window.location.href = "blacklist.php?user=" + buyer_id +"&seller=<?php echo $user_id;?>&cancel_count=" + cancel_count ;
        }
    </script>

</body>

</html>

<?php
mysqli_close($link);
?>
