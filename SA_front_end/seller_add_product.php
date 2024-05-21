<!DOCTYPE html>

<html lang="en">

<head>
    <title>上架商品</title>
    <?php include '_head.html'; ?>
    <style>
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
    <?php include '_seller_header.php'; ?>

    <!-- Main Menu Section -->
    <?php include '_seller_menu.html'; ?>

    <section class="page-header">
        <div class="container">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">上架商品</h1>
                    <ol class="breadcrumb">
                        <li><a href="seller.html">Home</a></li>
                        <li class="active">上架商品</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="page-wrapper">
        <div class="checkout shopping">
            <input type=hidden name="dbaction" value="insert">
            <div class="container">
                <form method="post" action="..\SA_back_end\seller_add.php" enctype="multipart/form-data">
                    <div class="row">
                            <div class="block billing-details">
                                <h4 class="widget-title" style="font-weight: bold;">Product Information</h4>
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="background-color: white;">名稱</td>
                                        <td colspan="3"><input type="text" class="form-control" name="PName" placeholder="盲盒" required></td>
                                    </tr>
                                    <tr>
                                        <td>種類</td>
                                        <td colspan="3">
                                            <select class="form-control" name="category" required>
                                                <option value="首飾">首飾</option>
                                                <option value="公仔">公仔</option>
                                                <option value="服飾">服飾</option>
                                                <option value="實用小物">實用小物</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>盲盒介紹</td>
                                        <td colspan="3"><textarea class="form-control" name="details" rows="5" placeholder="可能內容物："></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>價錢</td>
                                        <td><input type="text" class="form-control" name="price" name="zipcode" value="$" placeholder="Price" required></td>
                                        <td>數量</td>
                                        <td><input type="text" class="form-control" name="quantity" name="city" value="" placeholder="Quantity" required></td>
                                    </tr>
                                </table>
                            </div>
                    </div>
            </div>
            <div class="block">
                <div class="card-details" style="text-align: center;">
                    <input class="btn btn-main mt-20" type="submit" name="submit" value="上架商品">
                </div>
            </div>
                </form>
        </div>
    </div>
    </div>

    <?php include '_footer.html'; ?>

    <?php include '_script.html'; ?>
</body>

</html>
