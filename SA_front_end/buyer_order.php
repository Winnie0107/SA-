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

    <!-- Modal for cancelling order -->
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

    <!-- Modal for viewing order status -->
    <div class="modal fade" id="orderStatusModal" tabindex="-1" role="dialog" aria-labelledby="orderStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderStatusModalLabel">訂單狀態</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="order-status" style="display: flex; flex-direction: column; align-items: flex-start; gap: 20px;">
                        <div class="stage" id="stage-1" style="display: flex; align-items: center; font-size: 18px; color: #ccc;">
                            <div id="dot-1" style="width: 12px; height: 12px; border-radius: 50%; background-color: #ccc; margin-right: 10px;"></div>
                            <div class="stage-label">訂單已確認</div>
                        </div>
                        <div style="font-size: 24px; color: #ccc; display: flex; align-items: center;">&#x2193;</div>
                        <div class="stage" id="stage-2" style="display: flex; align-items: center; font-size: 18px; color: #ccc;">
                            <div id="dot-2" style="width: 12px; height: 12px; border-radius: 50%; background-color: #ccc; margin-right: 10px;"></div>
                            <div class="stage-label">賣家已出貨</div>
                        </div>
                        <div style="font-size: 24px; color: #ccc; display: flex; align-items: center;">&#x2193;</div>
                        <div class="stage" id="stage-3" style="display: flex; align-items: center; font-size: 18px; color: #ccc;">
                            <div id="dot-3" style="width: 12px; height: 12px; border-radius: 50%; background-color: #ccc; margin-right: 10px;"></div>
                            <div class="stage-label">買家已取貨</div>
                        </div>
                        <div style="font-size: 24px; color: #ccc; display: flex; align-items: center;">&#x2193;</div>
                        <div class="stage" id="stage-4" style="display: flex; align-items: center; font-size: 18px; color: #ccc;">
                            <div id="dot-4" style="width: 12px; height: 12px; border-radius: 50%; background-color: #ccc; margin-right: 10px;"></div>
                            <div class="stage-label">訂單已完成</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.cancel-order-btn').click(function () {
                var orderNumber = $(this).data('order-number');
                $('#orderNumberInput').val(orderNumber);
            });

            $('.order-status-link').click(function (e) {
                e.preventDefault();
                var orderNumber = $(this).data('order-number');
                $.ajax({
                    url: '../SA_back_end/buyer_order.php',
                    method: 'GET',
                    data: { get_order_status: true, order_number: orderNumber },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.error) {
                            alert(data.error);
                        } else {
                            updateOrderStatusModal(data);
                        }
                    }
                });
            });

            function updateOrderStatusModal(data) {
                var stages = [
                    { stage: 'stage-1', dot: 'dot-1', condition: data.state >= 1 },
                    { stage: 'stage-2', dot: 'dot-2', condition: data.ship == 1 },
                    { stage: 'stage-3', dot: 'dot-3', condition: data.pick == 1 },
                    { stage: 'stage-4', dot: 'dot-4', condition: data.ship == 1&& data.pick==1 }
                ];

                stages.forEach(function (stage) {
                    if (stage.condition) {
                        $('#' + stage.stage).css('color', '#000');
                        $('#' + stage.dot).css('background-color', '#02C874');
                    } else {
                        $('#' + stage.stage).css('color', '#ccc');
                        $('#' + stage.dot).css('background-color', '#ccc');
                    }
                });

                $('#orderStatusModal').modal('show');
            }
        });
    </script>

    <?php include '_footer.html'; ?>
    <?php include '_script.html'; ?>
</body>
</html>
