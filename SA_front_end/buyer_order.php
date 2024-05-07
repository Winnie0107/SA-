<!DOCTYPE html>

<html lang="en">

<head>
    <title>我的訂單</title>
    <?php include '_head.html'; ?>
    <style>
        td {
            vertical-align: middle !important;
        }

        .page-wrapper {
            padding: 20px 0;
        }

        label {
            font-size: large;
        }
    </style>
</head>

<body id="body">

    <!-- Header -->
    <?php include '_buyer_header.php'; ?>

    <!--  Menu -->
    <?php include '_buyer_menu.html'; ?>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">我的訂單</h1>
                        <ol class="breadcrumb">
                            <li><a href="buyer.html">Home</a></li>
                            <li class="active">我的訂單</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="dashboard-wrapper user-dashboard">
                    <div class="table-responsive">
                        <?php include '../SA_back_end/buyer_order.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <!-- modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" role="dialog" aria-labelledby="cancelOrderModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label for="cancelReason">請輸入取消訂單的原因：</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                     提醒您，單方面取消訂單可能導致賣家將您加入黑名單
                </div>
                <form id="cancelOrderForm" method="post" action="../SA_back_end/mail_cancel.php">
                    <div class="form-group">
                        <textarea class="form-control" id="cancelReason" name="cancel_reason" rows="4"></textarea>
                    </div>
                    <input type="hidden" id="orderNumberInput" name="order_number">
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger" name="cancel_order_confirm">確定取消</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Import jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        // JavaScript code to set order number in the modal
        $(document).ready(function () {
            $('.cancel-order-btn').click(function () {
                var orderNumber = $(this).data('order-number');
                $('#orderNumberInput').val(orderNumber);
            });
        });
    </script>

    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>

</body>

</html>