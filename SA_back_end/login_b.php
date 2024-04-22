<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678');
mysqli_select_db($link, 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account = mysqli_real_escape_string($link, $_POST['account']);
    $password = mysqli_real_escape_string($link, $_POST['password']);

    $sql = "SELECT * FROM user WHERE account = '$account' AND acco_level = '買家'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($user['password'] == $password) {
            $_SESSION['user_account'] = $account;
            $_SESSION['user_password'] = $user['password'];
            $_SESSION['user_level'] = $user['acco_level'];
            $_SESSION['user_email'] = $user['email'];

            $_SESSION['user_id'] = $user['ID'];

            $user_id = $user['ID'];
            $query = "SELECT SNumber FROM `shopping cart` WHERE buyer_ID = $user_id";
            $cart_result = mysqli_query($link, $query);
            if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                $cart_row = mysqli_fetch_assoc($cart_result);
                $_SESSION['SNumber'] = $cart_row['SNumber'];
            }

            header("Location:../SA_front_end/buyer_index.php");
            exit();
        } else {
            echo "登入失敗，密碼不正確。";
            echo "<br><br><button onclick='window.location.href=\"../SA_front_end/login.php\"'>返回</button>";
        }
    } else {
        echo "登入失敗，代號不存在或不是買家。";
        echo "<br><br><button onclick='window.location.href=\"../SA_front_end/login.php\"'>返回</button>";
    }
}
?>