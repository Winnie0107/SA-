<?php
session_start();
?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>HOME</title>
	<style>
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
                                <!-- Comment Item start-->
                                <li class="media">

                                    <a class="pull-left" href="#!">
                                        <img class="media-object comment-avatar" src="https://img.ixintu.com/download/jpg/202001/393f66193110479438efe843d3d5a8f7.jpg!ys" alt=""
                                            width="50" height="50" />
                                    </a>

                                    <div class="media-body">
                                        <div class="comment-info">
                                            <h4 class="comment-author">
                                                <a href="#!">Jonathon Andrew</a>

                                            </h4>
                                            <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                            <a class="comment-button" href="#!"><i
                                                    class="tf-ion-chatbubbles"></i>Reply</a>
                                        </div>

                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at
                                            magna ut ante eleifend eleifend.Lorem ipsum dolor sit amet, consectetur
                                            adipisicing elit. Quod laborum minima, reprehenderit laboriosam officiis
                                            praesentium? Impedit minus provident assumenda quae.
                                        </p>
                                    </div>

                                </li>
                                <!-- End Comment Item -->

                                <!-- Comment Item start-->
                                <li class="media">

                                    <a class="pull-left" href="#!">
                                        <img class="media-object comment-avatar" src="https://img.ixintu.com/download/jpg/202001/393f66193110479438efe843d3d5a8f7.jpg!ys" alt=""
                                            width="50" height="50" />
                                    </a>

                                    <div class="media-body">

                                        <div class="comment-info">
                                            <div class="comment-author">
                                                <a href="#!">Jonathon Andrew</a>
                                            </div>
                                            <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                            <a class="comment-button" href="#!"><i
                                                    class="tf-ion-chatbubbles"></i>Reply</a>
                                        </div>

                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at
                                            magna ut ante eleifend eleifend. Lorem ipsum dolor sit amet, consectetur
                                            adipisicing elit. Magni natus, nostrum iste non delectus atque ab a
                                            accusantium optio, dolor!
                                        </p>

                                    </div>

                                </li>
                                <!-- End Comment Item -->

                                <!-- Comment Item start-->
                                <li class="media">

                                    <a class="pull-left" href="#!">
                                        <img class="media-object comment-avatar" src="https://img.ixintu.com/download/jpg/202001/393f66193110479438efe843d3d5a8f7.jpg!ys" alt=""
                                            width="50" height="50">
                                    </a>

                                    <div class="media-body">

                                        <div class="comment-info">
                                            <div class="comment-author">
                                                <a href="#!">Jonathon Andrew</a>
                                            </div>
                                            <time datetime="2013-04-06T13:53">July 02, 2015, at 11:34</time>
                                            <a class="comment-button" href="#!"><i
                                                    class="tf-ion-chatbubbles"></i>Reply</a>
                                        </div>

                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at
                                            magna ut ante eleifend eleifend.
                                        </p>

                                    </div>

                                </li>
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