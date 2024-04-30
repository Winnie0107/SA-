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
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" font-size="40"
                                font-family="AustinBold, Austin" font-weight="bold">
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

                        $link = mysqli_connect('localhost', 'root', '12345678');
                        mysqli_select_db($link, 'box');

                        if (!$link) {
                            die("資料庫連接失敗: " . mysqli_connect_error());
                        }

                        // 檢查是否是 POST 請求
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $account = mysqli_real_escape_string($link, $_POST['account']);
                            $password = mysqli_real_escape_string($link, $_POST['password']);

                            $sql = "SELECT * FROM user WHERE account = '$account' AND acco_level = '賣家'";
                            $result = mysqli_query($link, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                $user = mysqli_fetch_assoc($result);

                                if ($user['password'] == $password) {
                                    // 登入成功，設置用戶相關的 SESSION 變數
                                    $_SESSION['user_account'] = $user['account']; // 將賣家的名稱存儲到 SESSION 中
                                    $_SESSION['user_level'] = $user['acco_level'];
                                    $_SESSION['user_email'] = $user['email'];
                                    $_SESSION['user_id'] = $user['ID'];

                                    // 如果需要的話，還可以處理購物車相關的邏輯

                                    // 重定向到賣家的首頁或任何其他賣家相關頁面
                                    header("Location: ../SA_front_end/seller_index.php");
                                    exit();
                                } else {
                                    // 密碼錯誤，顯示錯誤消息
                                    echo "登入失敗，密碼不正確。";
                                    echo "<br><br><button onclick='window.location.href=\"../SA_front_end/login.php\"'>返回</button>";
                                }
                            } else {
                                // 找不到賣家帳號，顯示錯誤消息
                                echo "登入失敗，賣家帳號不存在。";
                                echo "<br><br><button onclick='window.location.href=\"../SA_front_end/login.php\"'>返回</button>";
                            }
                        }
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