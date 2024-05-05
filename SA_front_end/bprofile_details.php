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

                            // 直接在 echo 语句中使用检索到的数据
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="media-body" style="display: flex; align-items: center; margin-left: 50px">';
                                echo '<img class="user-img-set" style="padding: 0px 25px; margin: 20px; transform: scale(1.2);" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="User Image">'; // 將 img 移至 div.media-body 內
                                echo '<ul class="user-profile-list">'; // 將 ul 移至 div.media-body 內
                                echo '<li><span>帳號名稱：</span>' . $row['account'] . '</li>';
                                echo '<li><span>帳號密碼：</span>' . $row['password'] . '</li>';
                                echo '<li><span>Email：</span>' . $row['email'] . '</li>';
                                echo '</ul>';
                                echo '</div>';
                            }

                            mysqli_close($link);
                            ?>
                            <div class="block">
                                <div class="card-details" style="text-align: right;">
                                    <a href="bupdate_profile.php" class="btn btn-main mt-20">修改個人資料</a>
                                </div>
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
