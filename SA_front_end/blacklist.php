<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>黑名單</title>
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

        .table-responsive {
            overflow-x: hidden; /* 隱藏水平滾動條 */
        }

        .table {
            width: 100%; /* 設置表格寬度為100% */
            table-layout: fixed; /* 設置表格布局為固定 */
            word-wrap: break-word; /* 確保長內容換行 */
        }

        .table th, .table td {
            text-align: center; /* 表格內容居中 */
        }

        /* 模态框样式 */
        .modal {
            display: none; /* 默认隐藏 */
            position: fixed; /* 固定定位，覆盖在页面之上 */
            z-index: 1; /* 放置在页面的最顶层 */
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0,0,0,0.4); /* 半透明背景 */
            justify-content: center; /* 水平居中 */
            align-items: center; /* 垂直居中 */
        }

        .modal-content {
            background-color: #fefefe; /* 模态框内容背景色 */
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px; /* 圆角边框 */
            width: 90%; /* 模态框内容宽度为90% */
            max-width: 500px; /* 最大宽度 */
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
            background-color: #d32f2f;
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
                        <h1 class="page-name">黑名單</h1>
                        <ol class="breadcrumb">
                            <li><a href="seller.html">Home</a></li>
                            <li class="active">黑名單</li>
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
                        <?php include '../SA_back_end/blacklist.php'; ?>
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
            <button class="btn btn-confirm" onclick="addToBlacklist()">確認</button>
            <button class="btn btn-cancel" onclick="hideConfirmation()">取消</button>
        </div>
    </div>

    <script>
        function showConfirmation(user_id, cancel_count) {
            var modal = document.getElementById("confirmationModal");
            modal.style.display = "flex";
            modal.dataset.userId = user_id;
            modal.dataset.cancelCount = cancel_count;
        }

        function hideConfirmation() {
            var modal = document.getElementById("confirmationModal");
            modal.style.display = "none";
        }

        function addToBlacklist() {
            var modal = document.getElementById("confirmationModal");
            var user_id = modal.dataset.userId;
            var cancel_count = modal.dataset.cancelCount;
            window.location.href = "add_to_blacklist.php?user=" + user_id + "&seller=<?php echo $_SESSION['user_id']; ?>&cancel_count=" + cancel_count;
        }
    </script>

    <!-- Footer -->
    <?php include '_footer.html'; ?>
    <!-- Scripts -->
    <?php include '_script.html'; ?>
</body>
</html>
