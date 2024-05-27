<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

// 每页显示的评论数量
$limit = 3;

// 获取当前页码
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if($page <= 0) $page = 1;

// 计算偏移量
$offset = ($page - 1) * $limit;

// 检查是否提供了商店编号
if(isset($_GET['store_number'])) {
    $store_number = $_GET['store_number'];

    // 查询总评论数
    $count_query = "SELECT COUNT(*) as total FROM review WHERE STNumber = ?";
    $count_stmt = mysqli_prepare($link, $count_query);
    mysqli_stmt_bind_param($count_stmt, "i", $store_number);
    mysqli_stmt_execute($count_stmt);
    $count_result = mysqli_stmt_get_result($count_stmt);
    $total_reviews = mysqli_fetch_assoc($count_result)['total'];

    // 计算总页数
    $total_pages = ceil($total_reviews / $limit);

    // 查询当前页的评论及相关产品信息
    $query = "SELECT review.*, user.account AS buyer_account, user.img AS buyer_img, `order item`.PNumber, product.PName
              FROM review
              INNER JOIN user ON review.ID = user.ID
              INNER JOIN order item ON review.OINumber = `order item`.OINumber
              INNER JOIN product ON `order item`.PNumber = product.PNumber
              WHERE review.STNumber = ?
              LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "iii", $store_number, $limit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Error fetching comments: " . mysqli_error($link));
    }

    echo '<style>
        .media { display: flex; margin-bottom: 20px; }
        .media-left { margin-right: 10px; }
        .media-body { flex: 1; }
        .review-image { margin-left: 20px; max-width: 200px; height: auto; }
        .pagination { list-style: none; padding: 0; display: flex; }
        .pagination li { margin: 0 5px; }
        .pagination a { text-decoration: none; color: black; padding: 5px 10px; }
        .pagination a:hover { text-decoration: underline; }
        .pagination span { padding: 5px 10px; color: black; }
        .comment-info { margin-bottom: 10px; }
        .comment-author { font-weight: bold; }
        .comment-content { color: #333; font-size: 16px; } /* 加深字体颜色并增大字体大小 */
    </style>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<ul>';
        echo '<li class="media">';
        echo '<a class="media-left" href="#!">';
        echo '<div class="circular-avatar" style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">';
        echo '<img class="media-object comment-avatar" src="data:image/jpeg;base64,' . base64_encode($row['buyer_img']) . '" alt="" style="width: 100%; height: 100%; object-fit: cover;" />';
        echo '</div>';
        echo '</a>';
        echo '<div class="media-body">';
        echo '<div class="comment-info">';
        echo '<h4 class="comment-author"><a href="#!">' . $row['buyer_account'] . '</a></h4>';
        echo '<time datetime="' . $row['ReviewTime'] . '">' . $row['ReviewTime'] . '</time>';
        echo '</div>';
        echo '<p class="comment-content">' . $row['ReviewContent'] . '</p>';  // 添加类名 comment-content
        // 顯示買家購買的商品
        echo '<p> 購買的商品： ' . $row['PName'] . '</p>';
        echo '</div>';
        // 顯示評論中的照片
        if ($row['img'] != NULL) {
            echo '<img class="review-image" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="Review Image" />';
        }
        echo '</li>';

        // 查詢回覆
        $reviewID = $row['ReviewID'];
        $reply_query = "SELECT reply.*, store_info.STName AS seller_name, store_info.img AS seller_img
                        FROM reply
                        INNER JOIN review ON reply.ReviewID = review.ReviewID
                        INNER JOIN store_info ON review.STNumber = store_info.STNumber
                        WHERE reply.ReviewID = ?";
        $reply_stmt = mysqli_prepare($link, $reply_query);
        if (!$reply_stmt) {
            die("準備查詢賣家回覆失敗: " . mysqli_error($link));
        }
        mysqli_stmt_bind_param($reply_stmt, "i", $reviewID);
        mysqli_stmt_execute($reply_stmt);
        $reply_result = mysqli_stmt_get_result($reply_stmt);

        while ($reply_row = mysqli_fetch_assoc($reply_result)) {
            echo '<li class="media reply">';
            echo '<div class="media-left">';
            echo '<div class="circular-avatar">';
            echo '<img class="media-object comment-avatar" src="data:image/jpeg;base64,' . base64_encode($reply_row['seller_img']) . '" alt="" style="width: 100%; height: 100%; object-fit: cover;" />';
            echo '</div>';
            echo '</div>';
            echo '<div class="media-body">';
            echo '<div class="comment-info">';
            echo '<h4 class="comment-author"><a href="#!">' . $reply_row['seller_name'] . '</a></h4>';
            echo '<time datetime="' . $reply_row['ReplyTime'] . '">' . $reply_row['ReplyTime'] . '</time>';
            echo '</div>';
            echo '<p class="comment-content">' . nl2br(htmlspecialchars($reply_row['ReplyContent'], ENT_QUOTES, 'UTF-8')) . '</p>';
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
    }

    // 分页链接
    echo '<ul class="pagination">';
    if($page > 1) {
        echo '<li><a href="?store_number=' . $store_number . '&page=' . ($page - 1) . '" class="pagination-link" style="border: none;">Previous</a></li>';
    }
    for($i = 1; $i <= $total_pages; $i++) {
        if($i == $page) {
            echo '<li><span class="pagination-link" style="border: none;">' . $i . '</span></li>';
        } else {
            echo '<li><a href="?store_number=' . $store_number . '&page=' . $i . '" class="pagination-link" style="border: none;">' . $i . '</a></li>';
        }
    }
    if($page < $total_pages) {
        echo '<li><a href="?store_number=' . $store_number . '&page=' . ($page + 1) . '" class="pagination-link" style="border: none;">Next</a></li>';
    }
    echo '</ul>';

    // 添加 JavaScript更改分頁導回當前位置
    echo '<script>
        document.querySelectorAll(".pagination-link").forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                var url = this.getAttribute("href");
                var scrollPosition = window.scrollY;

                fetch(url)
                    .then(response => response.text())
                    .then(data => {
                        document.body.innerHTML = data;
                        window.scrollTo(0, scrollPosition);
                        attachPaginationEventListeners();
                    });
            });
        });

        function attachPaginationEventListeners() {
            document.querySelectorAll(".pagination-link").forEach(function(link) {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    var url = this.getAttribute("href");
                    var scrollPosition = window.scrollY;

                    fetch(url)
                        .then(response => response.text())
                        .then(data => {
                            document.body.innerHTML = data;
                            window.scrollTo(0, scrollPosition);
                            attachPaginationEventListeners();
                        });
                });
            });
        }
    </script>';

} else {
    echo "未提供商店编号。";
}
?>