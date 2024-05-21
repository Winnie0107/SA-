<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout</title>
    <?php include '_head.html'; ?>
    <style>
        button {
            border: none;
            color: indianred;
            background: none;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        .page-wrapper {
            padding: 20px 0;
        }
    </style>
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
                        <h1 class="page-name">Checkout</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">checkout</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="page-wrapper">
        <div class="checkout shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="block billing-details">
                            <h4 class="widget-title" style="font-weight: bold;">Contact Information</h4>
                            <form class="checkout-form" method="POST" action="../SA_back_end/buyer_place_order.php">
                                <div class="form-group">
                                    <label for="user_address">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder=""
                                        value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>"
                                        readonly>
                                </div>
                                <div class="checkout-country-code clearfix">
                                    <div class="form-group">
                                        <label for="full_name">Account</label>
                                        <input type="text" class="form-control" id="account" name="account"
                                            placeholder=""
                                            value="<?php echo isset($_SESSION['user_account']) ? $_SESSION['user_account'] : ''; ?>"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_address">Phone Number</label>
                                        <input type="text" class="form-control" id="phonenumber" name="phonenumber"
                                            value="" pattern="[0-9]{10}" required>
                                    </div>
                                </div>
                                <p style="font-size: 12px; padding: 10px; color: red;">*手機號碼為必填</p>

                        </div>
                        <div class="block">
                            <div class="checkout-product-details">
                                <div class="payment">
                                    <div class="card-details">
                                        <button type="submit" class="btn btn-main mt-20">Place Order</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="product-checkout-details">
                            <div class="block">
                                <h4 class="widget-title" style="font-weight: bold;">Order Summary</h4>
                                <?php include '../SA_back_end/buyer_checkout.php'; ?>
                                <div class="discount-code">
                                    <div class="summary-total">
                                        <span>Total</span>
                                        <span>$<?php echo $totalPrice; ?></span>
                                    </div>
                                </div>
                                <div class="verified-icon">
                                    <img src="https://bcnretail.kuroco.app/files/user/201911291708_1.jpg?v=1575014890">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>

</body>

</html>