<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>我的商品</title>
    <style>
        .product-item .product-thumb img.img-set {
            width: 100%;
            height: 240px;
        }
        img.img-set {
            width: 385px;
            height: 270px;
        }
    </style>
    <?php include '_head.html'; ?>
</head>

<body id="body">

    <!-- Header -->
    <?php include '_seller_header.php'; ?>
    <!-- Main Menu Section -->
    <?php include '_seller_menu.html'; ?>

    <!-- store_info -->
    <?php include '../SA_back_end/seller_store_page.php'; ?>

    <section class="products section bg-gray">
        <div class="row">
            <div class="title text-center">
                <h2><strong>已上架的商品</strong></h2>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Products -->
                <?php include '../SA_back_end/seller_product.php'; ?>
            </div>
        </div>
    </section>

    <section class="products section bg-gray">
        <div class="row">
            <div class="title text-center">
                <h2><strong>需補充庫存的商品</strong></h2>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Products -->
                <?php include '../SA_back_end/seller_restock_product.php'; ?>
            </div>
        </div>
    </section>

    <section class="single-product">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tabCommon mt-20">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#details" aria-expanded="true">買家評價</a>
                            </li>
                        </ul>

                        <div class="post-comments">
                            <ul class="media-list comments-list m-bot-50 clearlist">
                                <!-- Comment Item start-->
                                <?php include '../SA_back_end/s_buyer_review.php'; ?>

                            </ul>
                        </div>
                    </div>
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