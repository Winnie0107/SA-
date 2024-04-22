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
                            <li><a href="seller.html">Home</a></li>
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


    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>

</body>
</html>