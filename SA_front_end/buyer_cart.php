<?php
include '../SA_back_end/buyer_cart.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cart</title>

    <?php include '_head.html'; ?>
    <style>
        button {
            border: none;
            color: red;
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

    <!-- Menu -->
    <?php include '_buyer_menu.html'; ?>

    <!-- 購物車資料 -->
    <?php include '../SA_back_end/buyer_cart.php';?>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Cart</h1>
                        <ol class="breadcrumb">
                            <li><a href="buyer_index.php">Home</a></li>
                            <li class="active">cart</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="col-md-8 col-md-offset-2">
                    <div class="block">
                        <div class="product-list">
                            <form method="post">
                                <table class="table">
                                    <tr>
                                        <th></th>
                                        <th>盲盒名稱</th>
                                        <th>價錢</th>
                                        <th>數量</th>
                                        <th>操作</th>
                                    </tr>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['img']) . "' alt='product-img' class='img-thumbnail' style='width: 120px; height: 100px;'></td>";
                                        echo "<td>" . $row['PName'] . "</td>";
                                        echo "<td>" . $row['price'] . "</td>";
                                        echo "<td>" . $row['quantity'] . "</td>";
                                        echo "<td><button type='submit'>移出購物車</button></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                                <a href="buyer_checkout.php" class="btn btn-main pull-right">前往結帳</a>
                            </form>
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

<?php
mysqli_close($link);
?>