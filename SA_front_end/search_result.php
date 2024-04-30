<!DOCTYPE html>
<html lang="en">

<head>
    <title>搜尋結果</title>
    <style>
        .search-form {
            display: flex;
            align-items: center;
        }

        .search-form .form-control {
            border-radius: 4px 0 0 4px;
            margin-right: 10px;
        }

        .search-form .btn {
            border-radius: 0 4px 4px 0;
        }


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

    <!-- 購物車資料 -->
    <?php include '../SA_back_end/buyer_cart.php'; ?>

    <section class="products section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <!-- Search -->
                        <div class="search">
                            <form method="POST" action="../SA_front_end/search_result.php" class="search-form">
                                <input type="text" name="search" class="form-control" placeholder="Search...">
                                <button type="submit" class="btn"><i class="tf-ion-ios-search-strong"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">搜尋結果</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Search</a></li>
                            <li class="active">result</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products section bg-gray">
        <div class="container">
            <div class="row mt-20">
                <!-- 搜尋結果 -->
                <?php include '../SA_back_end/search.php'; ?>
            </div>
        </div>
    </section>


    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>

</body>

</html>