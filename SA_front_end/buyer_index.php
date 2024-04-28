<!DOCTYPE html>

<html lang="en">

<head>
    <title>HOME</title>
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

    <!-- Slider -->
    <?php include '_buyer_slider.html'; ?>

    <section class="products section bg-gray">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2><strong>最新盲盒 New！</strong></h2>
                </div>
            </div>
            <div class="row">
                <!-- Products -->
                <?php include '../SA_back_end/buyer_index.php'; ?>
            </div>
        </div>
    </section>

    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>

</body>
</html>