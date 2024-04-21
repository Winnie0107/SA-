<!DOCTYPE html>

<html lang="en">

<head>
    <title>HOME</title>
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
                    <h2><strong>最新上架 New</strong></h2>
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