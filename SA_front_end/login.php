<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <?php include '_head.html'; ?>
</head>

<body id="body">

    <section class="signin-page account">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <a class="logo" href="index.html">
                            <img src="..\images/logo.png" alt="">
                        </a>
                        <h2 class="text-center">Welcome </h2>
                        <ul class="nav nav-tabs my-5">
                            <li class="active"><a href="#user" data-toggle="tab">買家</a></li>
                            <li><a href="#manager" data-toggle="tab">賣家</a></li>
                        </ul>

                        <div class="tab-content mt-4">
                            <div class="tab-pane fade in active" id="user">
                                <form action="..\SA_back_end\login_b.php" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="account" placeholder="帳號名稱">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="密碼">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-main text-center">Login</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="manager">
                                <form action="..\SA_back_end\login_s.php" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="account" placeholder="帳號名稱">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="密碼">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-main text-center">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <p class="mt-20">New in this site ?<a href="..\SA_front_end\signin.php"> Create New Account</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include '_script.html'; ?>
</body>

</html>