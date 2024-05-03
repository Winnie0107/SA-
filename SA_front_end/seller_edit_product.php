<!DOCTYPE html>

<html lang="en">

<head>
    <title>修改商品資訊</title>
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
                    <h1 class="page-name">修改商品資訊</h1>
                    <ol class="breadcrumb">
                        <li><a href="seller.html">Home</a></li>
                        <li class="active">修改商品資訊</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="page-wrapper">
        <div class="checkout shopping">
            <input type=hidden name="dbaction" value="insert">
            <div class="container">
                <?php
                session_start();

                if (isset($_GET['PNumber'])) {
                    $product_id = $_GET['PNumber'];

                    $link = mysqli_connect('localhost', 'root', '12345678', 'box');
                    if (!$link) {
                        die("Error" . mysqli_connect_error());
                    }

                    $query = "SELECT * FROM product WHERE PNumber = '$product_id'";
                    $result = mysqli_query($link, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $product = mysqli_fetch_assoc($result);
                    } else {
                        die("Error: Product not found");
                    }
                }
                ?>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8" style="width: 70%;">
                            <div class="block billing-details">
                                <h4 class="widget-title" style="font-weight: bold;">Edit Product Information</h4>
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="background-color: ;">名稱</td>
                                        <td colspan="3"><input type="text" class="form-control" name="PName"
                                                value="<?php echo isset($product['PName']) ? $product['PName'] : ''; ?>"
                                                placeholder="Product Name Please!" required></td>
                                    </tr>
                                    <tr>
                                        <td>種類</td>
                                        <td colspan="3">
                                            <select class="form-control" name="category" required>
                                                <option value="首飾" <?php echo (isset($product['category']) && $product['category'] == '首飾') ? 'selected' : ''; ?>>首飾</option>
                                                <option value="公仔" <?php echo (isset($product['category']) && $product['category'] == '公仔') ? 'selected' : ''; ?>>公仔</option>
                                                <option value="服飾" <?php echo (isset($product['category']) && $product['category'] == '服飾') ? 'selected' : ''; ?>>服飾</option>
                                                <option value="實用小物" <?php echo (isset($product['category']) && $product['category'] == '實用小物') ? 'selected' : ''; ?>>實用小物</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>盲盒介紹</td>
                                        <td colspan="3"><textarea class="form-control" name="details" rows="5"
                                                placeholder="You can list the potential items that might appear in your Mystery Box!"><?php echo isset($product['details']) ? $product['details'] : ''; ?></textarea></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>價錢</td>
                                        <td><input type="text" class="form-control" name="price"
                                                value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>"
                                                placeholder="Price" required></td>
                                        <td>數量</td>
                                        <td><input type="text" class="form-control" name="quantity"
                                                value="<?php echo isset($product['quantity']) ? $product['quantity'] : ''; ?>"
                                                placeholder="Quantity" required></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4" style="width: 30%;">
                            <div class="product-checkout-details">
                                <div class="block">
                                    <h4 class="widget-title" style="font-weight: bold;">Change Photo</h4>
                                    <div class="media product-card">
                                        <?php if (isset($product['img'])): ?>
                                            <img class="img-responsive"
                                                src="data:image/jpeg;base64, <?php echo base64_encode($product['img']); ?>"
                                                alt="Product Image">
                                        <?php endif; ?>
                                        <input type="file" id="upload" name="img" accept="image/*"
                                            style="display: inline-block ;">
                                        <div id="image-preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="block">
                <div class="card-details" style="text-align: center;">
                    <input class="btn btn-main mt-20" type="submit" name="submit" value="修改商品資訊">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '_footer.html'; ?>

    <script>
        document.getElementById('upload').addEventListener('change', function (event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function () {
                var img = document.createElement('img');
                img.src = reader.result;
                img.style.height = '220px';
                img.style.width = '320px'
                document.getElementById('image-preview').innerHTML = '';
                document.getElementById('image-preview').appendChild(img);
            };
            reader.readAsDataURL(input.files[0]);
        });
    </script>

    <?php include '_script.html'; ?>
</body>

</html>