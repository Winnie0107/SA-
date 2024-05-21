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

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Cart</h1>
                        <ol class="breadcrumb">
                            <li><a href="buyer_index.php">Home</a></li>
                            <li class="active">購物車</li>
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
                            <form method="post" action="../SA_back_end/delete_cart_item.php">
                                <?php
                                session_start();

                                $link = mysqli_connect('localhost', 'root', '12345678', 'box');

                                if (!$link) {
                                    die("Error" . mysqli_connect_error());
                                }

                                $cart_id = $_SESSION['SNumber'];
                                $query = "SELECT `shopping cart item`.SINumber, `shopping cart item`.quantity AS cart_quantity, product.*, product.quantity AS product_quantity 
                                FROM `shopping cart item` 
                                JOIN product ON `shopping cart item`.PNumber = product.PNumber 
                                WHERE SNumber = $cart_id";

                                $result = mysqli_query($link, $query);

                                if (!$result) {
                                    die("Error" . mysqli_error($link));
                                }
                                ?>
                                <form method="post" action="../SA_back_end/delete_cart_item.php">
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
                                            echo "<td>" . $row['cart_quantity'] . "</td>";
                                            echo "<td><button type='submit' name='SINumber' value='" . $row['SINumber'] . "'>移出購物車</button></td>";
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