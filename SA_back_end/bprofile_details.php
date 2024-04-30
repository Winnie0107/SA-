<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

$query = "SELECT * FROM user WHERE ID = $user_id"; // 從 user 表中選擇所有資訊，限制條件是使用者的 ID
$result = mysqli_query($link, $query);

if (!$result) {
    die("Error: " . mysqli_error($link));
}

// 將資料庫查詢的結果保存到 $row 變數中
$row = mysqli_fetch_assoc($result);

// Output the HTML content
echo '<div class="media-body" style="display: flex; align-items: center; margin:40px">';
if (!empty($row['img'])) {
    // 如果 img 字段不为空值，则显示数据库中存储的图片
    echo '<div class="media-body">';
    echo '<img class="media-object user-img" style="padding: 0px 25px; margin: 20px; transform: scale(1.2);" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="User Image">';
    echo '</div>';
} else {
    // 如果 img 字段为空值，则显示默认图片的 URL
    echo '<img class="media-object user-img" style="padding: 0px 25px; margin: 20px; transform: scale(1.2);" src="https://i.pinimg.com/564x/7b/38/43/7b3843fac19fdd6fec7e51769e240799.jpg" alt="User Image">';
}
echo '<ul class="user-profile-list">'; // 將 ul 移至 div.media-body 內
echo '<li><span>帳號名稱：</span>' . $row['account'] . '</li>';
echo '<li><span>帳號密碼：</span>' . $row['password'] . '</li>';
echo '<li><span>Email：</span>' . $row['email'] . '</li>';
echo '</ul>';
echo '</div>';
mysqli_close($link);
?>


