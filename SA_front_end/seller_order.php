<!DOCTYPE html>

<html lang="en">

<head>
    <title>我的商品</title>
    <?php include '_head.html'; ?>
</head>

<body id="body">

    <!-- Header -->
    <?php include '_seller_header.html'; ?>
    <!-- Main Menu Section -->
    <?php include '_seller_menu.html'; ?>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">訂單狀況</h1>
                        <ol class="breadcrumb">
                            <li><a href="seller.html">Home</a></li>
                            <li class="active">訂單狀況</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="dashboard-wrapper user-dashboard">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>訂單日期</th>
                                    <th>商品名稱</th>
                                    <th>數量</th>
                                    <th>總價</th>
                                    <th>用戶名稱</th>
                                    <th>電話號碼</th>
                                    <th>LINE ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mar 25, 2024</td>
                                    <td>戒指盲盒</td>
                                    <td>2</td>
                                    <td>$200.00</td>
                                    <td>林小姐</td>
                                    <td>0987763221</td>
                                    <td>yyy123</td>
                                </tr>
                                <tr>
                                    <td>Mar 26, 2024</td>
                                    <td>貼紙盲盒</td>
                                    <td>3</td>
                                    <td>$150.00</td>
                                    <td>黃小姐</td>
                                    <td>0987654321</td>
                                    <td>dkn544</td>
                                </tr>
                                <tr>
                                    <td>Mar 27, 2024</td>
                                    <td>手環盲盒</td>
                                    <td>1</td>
                                    <td>$100.00</td>
                                    <td>高先生</td>
                                    <td>0912344321</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Mar 28, 2024</td>
                                    <td>項鍊盲盒</td>
                                    <td>2</td>
                                    <td>$200.00</td>
                                    <td>陳先生</td>
                                    <td>0989878321</td>
                                    <td>ffff788</td>
                                </tr>
                                <tr>
                                    <td>Mar 29, 2024</td>
                                    <td>帽子盲盒</td>
                                    <td>3</td>
                                    <td>$450.00</td>
                                    <td>王小姐</td>
                                    <td>0988798321</td>
                                    <td>djk222</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include '_footer.html'; ?>
    <!-- Scripts -->
    <?php include '_script.html'; ?>
</body>

</html>