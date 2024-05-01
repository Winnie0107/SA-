<!-- Start Top Header Bar -->
<section class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-12 col-sm-4">
                <div class="contact-number">
                    <i class="archive"></i>
                    <span style="font-size: 20px; font-weight: bold; color: #333; font-family: 'Arial', sans-serif;">惜物盲盒
                        <span style="font-style: italic; font-family: 'Regular 400', sans-serif;">Mysterious Box
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 col-sm-4">
                <div class="logo text-center">
                    <a href="seller.html">
                        <!-- replace logo here -->
                        <svg width="135px" height="29px" viewBox="0 0 155 29" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" font-size="40" font-family="AustinBold, Austin" font-weight="bold">
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
                    <li class="dropdown order-nav dropdown-slide">
                        <a href="seller_order.php">&#128221;
                            訂單狀況</a>
                    </li>
                    <!-- Account Login -->
                    <?php
                    session_start();
                    ?>
                    <li class="dropdown account dropdown-slide">
                        <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                            <i class="tf-ion-ios-person"></i> 哈囉，<?php echo $_SESSION['user_account']; ?>！
                        </a>
                        <ul class="dropdown-menu account-dropdown">
                            <li><a href="../SA_back_end/logout.php">修改個人信息</a></li>
                            <li><a href="../SA_back_end/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
