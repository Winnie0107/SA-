<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>商店一覽</title>
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

    <section class="products section bg-gray">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2><strong>全部商店</strong></h2>
                </div>
            </div>
            <div class="row">

                <?php include '../SA_back_end/buyer_store.php'; ?>
            </div>
        </div>
    </section>


    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>

</body>

</html>