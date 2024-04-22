<?php
session_start();
?>

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

    <!-- Footer -->
    <?php include '_footer.html'; ?>
    <!-- Scripts -->
    <?php include '_script.html'; ?>

</body>

</html>