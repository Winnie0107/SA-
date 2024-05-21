<?php
session_start();
?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>HOME</title>
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
	<?php include '_buyer_header.php'; ?>

	<!--  Menu -->
	<?php include '_buyer_menu.html'; ?>

	<!-- store_info -->
    <?php include '../SA_back_end/buyer_store_page.php'; ?>

	<section class="products section bg-gray">
        <div class="row">
            <div class="title text-center">
                <h2><strong>賣場商品列表</strong></h2>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Products -->
                <?php include '../SA_back_end/buyer_store_product.php'; ?>
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
                                
                            <?php include '../SA_back_end/buyer_review.php'; ?>
                                   
                              
                            </ul>
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