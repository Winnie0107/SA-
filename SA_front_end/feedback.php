<!DOCTYPE html>
<html lang="en">
<head>
    <title>Feedback</title>
    <?php include '_head.html'; ?>
    <style>
        td {
            padding: 10px;
            text-align: center;
        }

        .page-wrapper {
            padding: 20px 0;
        }

        table {
            margin-left: 40px;
        }

        h4{
            border-bottom: 3px solid;
            border-bottom: 1px solid #dedede;
            padding-bottom: 15px;
            margin-bottom: 15px;
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
                        <h1 class="page-name">Feedback</h1>
                        <ol class="breadcrumb">
                            <li><a href="buyer.html">Home</a></li>
                            <li class="active">意見回饋</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="giving-feedback">
            <input type="hidden" name="dbaction" value="insert">
            <div class="container" style="padding:10px;">
                <form method="post" action="../SA_back_end/feedback.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="block billing-details">
                            <h4 class="widget-title" style="font-weight: bold; font-size:17px;">
                                歡迎留下訊息給我們的平台工程師，告訴我們哪裡需要改進！
                            </h4>
                            <table style="width: 90%;">
                                <tr>
                                    <td>標題</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="title" placeholder="先下個標題吧！" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>內容</td>
                                    <td colspan="3">
                                        <textarea class="form-control" name="content" rows="5" placeholder="請在此說明" required></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="block">
                        <div class="card-details" style="text-align: center;">
                            <input class="btn btn-main mt-20" type="submit" name="submit" value="送出">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '_footer.html'; ?>

    <!-- Script -->
    <?php include '_script.html'; ?>

    <!-- Additional Script for Debugging -->
    <script>
        function validateForm() {
            console.log("Form submitted");
            return true; // Ensure form is submitted
        }
    </script>
</body>
</html>
