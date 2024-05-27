<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>取消訂單明細</title>
    <?php include '_head.html'; ?>
    <style>
        td {
            vertical-align: middle !important;
        }
        .page-wrapper {
            padding: 20px 0;
        }   
        
    </style>
</head>
<body id="body">

    <!-- Header -->
    <?php include '_seller_header.php'; ?>
    <!-- Main Menu Section -->
    <?php include '_seller_menu.html'; ?>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">取消訂單明細</h1>
                        <ol class="breadcrumb">
                            <li><a href="seller.html">Home</a></li>
                            <li class="active">取消訂單明細</li>
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
                        <?php include '../SA_back_end/cancelled_detail.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include '_footer.html'; ?>
    <!-- Scripts -->
    <?php include '_script.html'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
