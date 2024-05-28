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

        button#selectStoreButton,
        button#selectStoreButton711 {
            margin-left: 15px;
        }

        ul.nav.nav-tabs {
            border-bottom: none;
            margin-bottom: 15px;
        }

        label.form-check-label {
            margin-left: 10px;
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
                                <h4 class="widget-title" style="font-weight: bold; margin-top: 30px;">Shipping</h4>

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#sevenElevenTab">7-ELEVEN</a></li>
                                    <li><a data-toggle="tab" href="#familyMartTab">全家</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="sevenElevenTab" class="tab-pane fade in active">
                                        <div class="checkout-country-code clearfix">
                                            <div class="form-group">
                                                <label for="store_address">Store</label>
                                                <input type="text" class="form-control" id="store_address_711"
                                                       name="shipping_store_711"
                                                       value="7-ELEVEN <?php echo isset($_GET['store711']) ? htmlspecialchars($_GET['store711']) : ''; ?>"
                                                       readonly>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-main" id="selectStoreButton711"
                                                        onclick="openEcpayLogistics711()">選擇門市
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="familyMartTab" class="tab-pane fade">
                                        <div class="checkout-country-code clearfix">
                                            <div class="form-group">
                                                <label for="store_address">Store</label>
                                                <input type="text" class="form-control" id="store_address_family"
                                                       name="shipping_store_family"
                                                       value="全家 <?php echo isset($_GET['store']) ? htmlspecialchars($_GET['store']) : ''; ?>"
                                                       readonly>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-main" id="selectStoreButton"
                                                        onclick="openEcpayLogistics()">選擇門市
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="widget-title" style="font-weight: bold; margin-top: 30px;">Payment</h4>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="flexRadioDefault2"
                                           value="1" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        線上支付
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="flexRadioDefault1"
                                           value="0">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        取貨付款 (超商代收)
                                    </label>
                                </div>

                                <input type="hidden" name="selected_store" id="selected_store" value="711"> <!-- 隱藏字段 -->

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

    <script>
        function openEcpayLogistics711() {
            var formData = {
                MerchantID: '2000933',
                MerchantTradeNo: 'Test' + Date.now(),
                LogisticsType: 'CVS',
                LogisticsSubType: 'UNIMARTC2C',
                IsCollection: 'Y',
                ServerReplyURL: 'https://2a01-125-229-150-20.ngrok-free.app/SA-/SA_back_end/ecpay_reply711.php', 
                ExtraData: '',
                Device: 0,
            };

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'https://logistics-stage.ecpay.com.tw/Express/map';

            for (var key in formData) {
                if (formData.hasOwnProperty(key)) {
                    var hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = key;
                    hiddenField.value = formData[key];
                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }

        function openEcpayLogistics() {
            var formData = {
                MerchantID: '2000933',
                MerchantTradeNo: 'Test' + Date.now(),
                LogisticsType: 'CVS',
                LogisticsSubType: 'FAMIC2C',
                IsCollection: 'Y',
                ServerReplyURL: 'https://2a01-125-229-150-20.ngrok-free.app/SA-/SA_back_end/ecpay_reply.php', 
                Device: 0,
            };

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'https://logistics-stage.ecpay.com.tw/Express/map';

            for (var key in formData) {
                if (formData.hasOwnProperty(key)) {
                    var hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = key;
                    hiddenField.value = formData[key];
                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }

        document.querySelector('.nav-tabs').addEventListener('click', function (event) {
            if (event.target.tagName === 'A') {
                var selectedStore = event.target.getAttribute('href').includes('sevenElevenTab') ? '711' : 'family';
                document.getElementById('selected_store').value = selectedStore;
            }
        });
    </script>
</body>
</html>