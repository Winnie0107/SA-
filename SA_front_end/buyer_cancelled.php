<?php
session_start();
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>買家取消訂單查詢</title>
    <?php include '_head.html'; ?>
    <style>
        td {
            vertical-align: middle !important;
        }

        .page-wrapper {
            padding: 20px 0;
        }

        .clickable {
            color: black;
            text-decoration: underline;
            cursor: pointer;
            font-weight: bold;
        }

        .btn {
            padding: 5px 10px;
            text-align: center;
            color: white;
            background-color: blue;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-blacklist {
            background-color: red;
        }

        /* 指定表格列寬度 */
        .table th,
        .table td {
            width: calc(100% / 3);
            /* 將寬度平均分配為三等分 */
        }

        /* 隱藏水平滾動條 */
        .table-responsive {
            overflow-x: hidden;
        }

    /* 模态框样式 */
    .modal {
        display: none; /* 默认隐藏 */
        position: fixed; /* 固定定位，覆盖在页面之上 */
        z-index: 1; /* 放置在页面的最顶层 */
        left: 0;
        top: 0;
        height: 100%;
        overflow: auto; /* 添加滚动条 */
        justify-content: center; /* 水平居中 */
    
    }

    .modal-content {
        background-color: #fefefe; /* 模态框内容背景色 */
        margin: 15% auto; /* 使模态框垂直居中 */
        padding: 20px;
        border: 1px solid #888;
        border-radius: 10px; /* 圆角边框 */
        width: 30%; /* 模态框内容宽度为模态框的70% */
    }

    /* 关闭按钮样式 */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* 按钮样式 */
    .btn-confirm,
    .btn-cancel {
        padding: 10px;
        margin-top: 10px;
        width: 45%; /* 按钮宽度为模态框内容宽度的45% */
        cursor: pointer;
    }

    .btn-confirm {
        background-color: #4CAF50; /* 确认按钮背景色 */
        color: white;
        border: none;
    }

    .btn-cancel {
        background-color: #f44336; /* 取消按钮背景色 */
        color: white;
        border: none;
    }

    .btn-confirm:hover {
        background-color: #45a049;
    }

    .btn-cancel:hover {
        background-color: #f44336;
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
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">買家取消訂單查詢</h1>
                        <ol class="breadcrumb">
                            <li><a href="seller.html">Home</a></li>
                            <li class="active">買家取消訂單查詢</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="dashboard-wrapper user-dashboard">
                    <div class="table-responsive">
                        <?php include '../SA_back_end/buyer_cancelled.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 確認提示模态框 -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideConfirmation()">&times;</span>
            <p>你確定要將該買家加入黑名單嗎？</p>
            <button type="submit" class="btn btn-confirm" onclick="addToBlacklist()">確認</button>
            <button class="btn btn-cancel" onclick="hideConfirmation()">取消</button>
        </div>
    </div>

    <!-- Footer -->
    <?php include '_footer.html'; ?>
    <!-- Scripts -->
    <?php include '_script.html'; ?>
</body>

</html>
