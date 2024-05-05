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
        .img-set {
            width: 385px;
            height: 270px;
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
                        <ul class="nav nav-tabs my-5">
                            <li <?php if(!isset($_POST['search_type']) || $_POST['search_type'] == 'product') echo 'class="active"'; ?>><a href="#product" data-toggle="tab" class="search-tab" data-type="product">依商品搜尋</a></li>
                            <li <?php if(isset($_POST['search_type']) && $_POST['search_type'] == 'store') echo 'class="active"'; ?>><a href="#store" data-toggle="tab" class="search-tab" data-type="store">依店家搜尋</a></li>
                        </ul>
                        <!-- Search -->
                        <div class="search" style="margin-top: 40px;">
                            <div class="tab-content">
                                <div class="tab-pane fade <?php if(!isset($_POST['search_type']) || $_POST['search_type'] == 'product') echo 'in active'; ?>" id="product">
                                    <form method="POST" action="../SA_front_end/search_result.php" class="search-form" id="productSearchForm">
                                        <input type="hidden" name="search" value="search">
                                        <input type="hidden" name="search_type" value="product">
                                        <input type="text" name="keyword" class="form-control" placeholder="Search...">
                                        <button type="submit" class="btn btn-search"><i class="tf-ion-ios-search-strong"></i></button>
                                    </form>
                                </div>

                                <div class="tab-pane fade <?php if(isset($_POST['search_type']) && $_POST['search_type'] == 'store') echo 'in active'; ?>" id="store">
                                    <form method="POST" action="../SA_front_end/search_result.php" class="search-form" id="storeSearchForm">
                                        <input type="hidden" name="search" value="search">
                                        <input type="hidden" name="search_type" value="store">
                                        <input type="text" name="keyword" class="form-control" placeholder="Search...">
                                        <button type="submit" class="btn btn-search"><i class="tf-ion-ios-search-strong"></i></button>
                                    </form>
                                </div>
                            </div>
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
                        <?php 
                    if(isset($_POST['search'])) {
                        if($_POST['search_type'] == 'product') {
                            include '../SA_back_end/search.php';
                        } elseif($_POST['search_type'] == 'store') {
                            include '../SA_back_end/search_s.php';
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function searchProduct() {
            document.getElementById("productSearchForm").action = "../SA_front_end/search_result.php";
            document.getElementById("productSearchForm").submit();
        }

        function searchStore() {
            document.getElementById("storeSearchForm").action = "../SA_front_end/search_result.php";
            document.getElementById("storeSearchForm").submit();
        }
    </script>

</body>

</html>