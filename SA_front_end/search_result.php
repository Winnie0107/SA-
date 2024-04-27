<!DOCTYPE html>
<html lang="en">

<head>
    <title>搜尋結果</title>
    <?php include '_head.html'; ?>
</head>

<body id="body">

    <!-- Header -->
    <?php include '_buyer_header.php'; ?>

    <!--  Menu -->
    <?php include '_buyer_menu.html'; ?>

    <!-- 購物車資料 -->
    <?php include '../SA_back_end/buyer_cart.php'; ?>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">搜尋結果</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Search</a></li>
                            <li class="active">result</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 搜尋結果 -->
    <?php include '../SA_back_end/search.php'; ?>

    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>

</body>

</html>
