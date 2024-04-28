<!DOCTYPE html>

<html lang="en">

<head>
    <title>建立商品主頁</title>
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

    <!-- Start Top Header Bar -->
    <section class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="contact-number">
                        <i class="archive"></i>
                        <span
                            style="font-size: 20px; font-weight: bold; color: #333; font-family: 'Arial', sans-serif;">惜物盲盒
                            <span style="font-style: italic; font-family: 'Regular 400', sans-serif;">Mysterious
                                Box
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="logo text-center">
                        <a href="seller.html">
                            <!-- replace logo here -->
                            <svg width="135px" height="29px" viewBox="0 0 155 29" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                    font-size="40" font-family="AustinBold, Austin" font-weight="bold">
                                    <g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
                                        <text id="AVIATO">
                                            <tspan x="108.94" y="325">HOME</tspan>
                                        </text>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <ul class="top-menu text-right list-inline">
                        <!-- Account Login -->
                        <li class="dropdown account dropdown-slide">
                            <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i
                                    class="tf-ion-ios-person"></i> Account</a>
                            <ul class="dropdown-menu account-dropdown">
                                <div class="col-sm-3 col-xs-12">
                                    <ul>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="../SA_back_end/logout.php">Logout </a></li>
                                    </ul>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <section class="page-header">
        <div class="container">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">建立商品主頁</h1>
                    <ol class="breadcrumb">
                        <li class="active">HELLO！歡迎您使用此平台，在開始上架商品前，請先建立商品主頁，和我們介紹一下自己吧！</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="page-wrapper">
        <div class="checkout shopping">
            <input type=hidden name="dbaction" value="insert">
            <div class="container">
                <form method="post" action="..\SA_back_end\seller_create_page.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-5" style="width: 35%;">
                            <div class="product-checkout-details">
                                <div class="block">
                                    <h4 class="widget-title" style="font-weight: bold;">請上傳商店封面照</h4>
                                    <div class="media product-card">
                                        <input type="file" id="upload" name="img" accept="image/*"
                                            style="display: inline-block ;">
                                    </div>
                                </div>
                                <div id="image-preview"></div>
                            </div>
                        </div>
                        <div class="col-md-7" style="width: 65%;">
                            <div class="block billing-details">
                                <h4 class="widget-title" style="font-weight: bold;">Store Information</h4>
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="background-color: ;">商店名稱</td>
                                        <td colspan="3"><input type="text" class="form-control" name="STName"
                                                placeholder="Store Name Please" required></td>
                                    </tr>
                                    <tr>
                                        <td>商店介紹</td>
                                        <td colspan="3"><textarea class="form-control" name="details" rows="10"
                                                placeholder="Tell us about your store"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="block">
                <div class="card-details" style="text-align: center;">
                    <input class="btn btn-main mt-20" type="submit" name="submit" value="建立商品主頁">
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