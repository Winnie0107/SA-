<?php
session_start();
$user_id = $_SESSION['user_id'];

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // 获取表单提交的数据
    $new_account = isset($_POST['account']) ? mysqli_real_escape_string($link, $_POST['account']) : '';
    $new_password = isset($_POST['password']) ? mysqli_real_escape_string($link, $_POST['password']) : '';

    $form_data = isset($_FILES['img']['tmp_name']) ? $_FILES['img']['tmp_name'] : '';

    $data = addslashes(file_get_contents($form_data));

    // 更新数据库中的数据，包括 email 和图片路径
    $query = "UPDATE user SET account='$new_account', password='$new_password', img='$data' WHERE ID=$user_id";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("Error: " . mysqli_error($link));
    }

    // 关闭数据库连接
    mysqli_close($link);

    // 重定向到 bprofile_details.php 页面
    header("Location: bprofile_details.php");
    exit();
}

// 获取用户的当前信息
$query = "SELECT * FROM user WHERE ID = $user_id";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Error: " . mysqli_error($link));
}

// 将查询结果保存到 $row 变量中
$row = mysqli_fetch_assoc($result);

// 关闭数据库连接
mysqli_close($link);
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <title>我的訂單</title>
    <?php include '_head.html'; ?>


    <style>
        img.user-img-set {
            width: 150px;
            padding: 0 !important;
            border-radius: 90px;
            margin: 20px 80px 20px 20px !important;
        }

        td {
            vertical-align: middle !important;
        }

        .page-wrapper {
            padding: 20px 0;
        }


        form input,
        form button {
            margin-bottom: 10px;
            /* 输入框和按钮之间的垂直间距 */
        }
    </style>
</head>

<body id="body">

    <!-- Header -->
    <?php include '_buyer_header.php'; ?>

    <!--  Menu -->
    <?php include '_buyer_menu.html'; ?>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">我的個人訊息</h1>
                        <ol class="breadcrumb">
                            <li><a href="buyer.html">Home</a></li>
                            <li class="active">修改個人訊息</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-wrapper dashboard-user-profile">
                        <div class="media">
                            <div class="media-body">
                                <form method="post" action="" enctype="multipart/form-data" style="display: flex; justify-content: center; align-items: center; width: 100%;">
                                    <div class="block" style="width: 35%; display: inline-block; vertical-align: top; margin-left: 5%;">
                                        <h4 class="widget-title" style="font-weight: bold;">上傳新的大頭貼</h4>
                                        <div class="media product-card">
                                            <input type="file" id="upload" name="img" accept="image/*" style="display: inline-block;">
                                        </div>
                                        <div id="image-preview"></div>
                                    </div>

                                    <script>
                                        document.getElementById('upload').addEventListener('change', function(event) {
                                            var file = event.target.files[0];
                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                var imagePreview = document.getElementById('image-preview');
                                                imagePreview.innerHTML = ''; // 清空預覽區域
                                                var img = document.createElement('img');
                                                img.src = e.target.result;
                                                img.style.width = '150px'; // 設置圖片寬度
                                                img.style.height = '150px'; // 設置圖片高度
                                                imagePreview.appendChild(img); // 將圖片添加到預覽區域
                                            }
                                            reader.readAsDataURL(file); // 讀取文件並轉換為 Data URL
                                        });
                                    </script>

                                    <div class="col-md-8" style="width: 65%; display: inline-block; vertical-align: top;">
                                        <input type="text" name="account" placeholder="新的帳號名稱" required style="width: 75%;"><br>
                                        <input type="password" name="password" placeholder="新的帳號密碼" required style="width: 75%;"><br>
                                        <div><?php echo $row['email']; ?></div>
                                        <button type="submit" name="submit" class="btn btn-main mt-20" style="width: 20%; margin-left: auto;">確定更改</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '_footer.html'; ?>
    <?php include '_script.html'; ?>
</body>

</html>