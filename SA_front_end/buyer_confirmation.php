<!DOCTYPE html>

<html lang="en">

<head>
    <title>下單成功</title>
    <?php include '_head.html'; ?>
</head>

<body id="body">

    <!-- Header -->
    <?php include '_buyer_header.php'; ?>

    <!-- Menu -->
    <?php include '_buyer_menu.html'; ?>

    <section class="page-wrapper success-msg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <i class="tf-ion-android-checkmark-circle"></i>
                        <h2 class="text-center">已完成下單！</h2>
                        <a href="buyer_product.php" class="btn btn-main mt-20">繼續逛逛</a>
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