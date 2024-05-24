<!DOCTYPE html>

<html lang="en">

<head>
    <title>修改商店主頁</title>
    <?php include '_head.html'; ?>
    <style>
        td {
            padding: 10px;
            text-align: center;
        }

        .page-wrapper {
            padding: 20px 0;
        }
    </style>
</head>

<body id="body">

    <!-- Header -->
    <?php include '_seller_header.php'; ?>

    <!-- Main Menu Section -->
    <?php include '_seller_menu.html'; ?>

    <section class="page-header">
        <div class="container">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">修改商店主頁</h1>
                    <ol class="breadcrumb">
                        <li><a href="seller.html">Home</a></li>
                        <li class="active">修改商店主頁</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="page-wrapper">
        <div class="checkout shopping">
            <input type=hidden name="dbaction" value="insert">
            <div class="container">
                <?php
                session_start();

                if (isset($_GET['STNumber'])) {
                    $page_id = $_GET['STNumber'];

                    $link = mysqli_connect('localhost', 'root', '12345678', 'box');
                    if (!$link) {
                        die("Error" . mysqli_connect_error());
                    }

                    $query = "SELECT * FROM store_info WHERE STNumber = '$page_id'";
                    $result = mysqli_query($link, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $page = mysqli_fetch_assoc($result);
                    } else {
                        die("Error: Product not found");
                    }
                }

                if (isset($_POST['submit'])) {
                    $STName = $_POST['STName'];
                    $details = $_POST['details'];

                    // 如果沒有輸入新的名稱，則保留原始資料庫中的值
                    if (empty($STName)) {
                        $STName = $page['STName'];
                    }

                    // 如果沒有輸入新的介紹，則保留原始資料庫中的值
                    if (empty($details)) {
                        $details = $page['details'];
                    }

                    // 處理上傳的圖片
                    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                        $img = addslashes(file_get_contents($_FILES['img']['tmp_name']));
                    } else {
                        // 沒有新的圖片被上傳，使用原本的圖片
                        $img = $page['img'];
                    }

                    // 更新資料庫的查詢語句
                    $update_query = "UPDATE store_info 
                                     SET STName='$STName', 
                                         details='$details'";

                    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                        $update_query .= ", img='$img'";
                    }

                    $update_query .= " WHERE STNumber='$page_id'";

                    // 執行更新資料庫的動作
                    $update_result = mysqli_query($link, $update_query);

                    if ($update_result) {
                        echo "<script>window.location.href = 'http://localhost/SA-/SA_front_end/seller_store_page.php';</script>";
                        echo "<div class='alert alert-success' role='alert'>商品資訊已成功修改！</div>";
                        exit(); // 確保在重定向後結束當前腳本的執行
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>修改商品資訊時發生錯誤。</div>";
                    }
                }
                ?>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-5" style="width: 35%;">
                            <div class="product-checkout-details">
                                <div class="block">
                                    <h4 class="widget-title" style="font-weight: bold;">請上傳商店封面照</h4>
                                    <div class="media product-card">
                                        <input type="file" id="upload" name="img" accept="image/*" style="display: inline-block;">
                                    </div>
                                </div>
                                <div id="image-preview"></div>
                            </div>
                        </div>
                        <div class="col-md-7" style="width: 65%;">
                            <div class="block billing-details">
                                <h4 class="widget-title" style="font-weight: bold;">Store Information</h4>
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="background-color: ;">商店名稱</td>
                                        <td colspan="3">
                                            <input type="text" class="form-control" name="STName" value="<?php echo isset($_POST['STName']) ? $_POST['STName'] : (isset($page['STName']) ? $page['STName'] : ''); ?>" placeholder="Page Name Please!" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>商店介紹</td>
                                        <td colspan="3">
                                            <textarea class="form-control" name="details" rows="10" placeholder=""><?php echo isset($_POST['details']) ? $_POST['details'] : (isset($page['details']) ? $page['details'] : ''); ?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="card-details" style="text-align: center;">
                            <input class="btn btn-main mt-20" type="submit" name="submit" value="修改商品主頁">
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <?php include '_footer.html'; ?>

    <script>
        document.getElementById('upload').addEventListener('change', function(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var img = document.createElement('img');
                img.src = reader.result;
                img.style.height = '220px';
                img.style.width = '320px'
                document.getElementById('image-preview').innerHTML = '';
                document.getElementById('image-preview').appendChild(img);
            };
            reader.readAsDataURL(input.files[0]);
        });
    </script>

    <?php include '_script.html'; ?>
</body>

</html>
