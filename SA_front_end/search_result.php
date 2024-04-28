<!DOCTYPE html>
<html lang="en">

<head>
    <title>搜尋結果</title>
    <style>
        .product-item .product-thumb img.img-set {
            width: 100%;
            height: 240px;
        }
    </style>
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

    <section class="products section bg-gray">
        <div class="container">
            <div class="row mt-20">
                <!-- 搜尋結果 -->
                <?php include '../SA_back_end/search.php'; ?>
            </div>
        </div>
    </section>


    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>

</body>

</html>