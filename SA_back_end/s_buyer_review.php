<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 每页显示的评论数量
$limit = 3;

// 获取当前页码
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page <= 0) $page = 1;

// 计算偏移量
$offset = ($page - 1) * $limit;

// 检查是否存储了卖家ID
if (isset($_SESSION['user_id'])) {
    $seller_id = $_SESSION['user_id'];

    // 查询卖家的店铺编号
    $store_query = "SELECT STNumber FROM store_info WHERE seller_ID = ?";
    $store_stmt = mysqli_prepare($link, $store_query);
    if (!$store_stmt) {
        die("準備查詢店鋪編號失敗: " . mysqli_error($link));
    }

    mysqli_stmt_bind_param($store_stmt, "i", $seller_id);
    if (!mysqli_stmt_execute($store_stmt)) {
        die("執行查詢店鋪編號失敗: " . mysqli_stmt_error($store_stmt));
    }

    $store_result = mysqli_stmt_get_result($store_stmt);
    if (!$store_result || mysqli_num_rows($store_result) == 0) {
        die("未找到該賣家的店鋪: " . mysqli_stmt_error($store_stmt));
    }

    $store_info = mysqli_fetch_assoc($store_result);
    $st_number = $store_info['STNumber'];

    // 查询总评论数
    $count_query = "SELECT COUNT(*) as total FROM review WHERE STNumber = ?";
    $count_stmt = mysqli_prepare($link, $count_query);
    if (!$count_stmt) {
        die("準備查詢總評論數失敗: " . mysqli_error($link));
    }

    mysqli_stmt_bind_param($count_stmt, "i", $st_number);
    if (!mysqli_stmt_execute($count_stmt)) {
        die("執行查詢總評論數失敗: " . mysqli_stmt_error($count_stmt));
    }

    $count_result = mysqli_stmt_get_result($count_stmt);
    if (!$count_result) {
        die("獲取總評論數結果失敗: " . mysqli_stmt_error($count_stmt));
    }

    $total_reviews = mysqli_fetch_assoc($count_result)['total'];
    if ($total_reviews === null) {
        die("總評論數查詢失敗或沒有評論: " . mysqli_stmt_error($count_stmt));
    }

    // 计算总页数
    $total_pages = ceil($total_reviews / $limit);

    // 查询当前页的评论及相关产品信息
    $query = "SELECT review.*, user.account AS buyer_account, user.img AS buyer_img, `order item`.PNumber, product.PName
              FROM review
              INNER JOIN user ON review.ID = user.ID
              INNER JOIN `order item` ON review.OINumber = `order item`.OINumber
              INNER JOIN product ON `order item`.PNumber = product.PNumber
              WHERE review.STNumber = ?
              LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($link, $query);
    if (!$stmt) {
        die("準備查詢評論失敗: " . mysqli_error($link));
    }

    mysqli_stmt_bind_param($stmt, "iii", $st_number, $limit, $offset);
    if (!mysqli_stmt_execute($stmt)) {
        die("執行查詢評論失敗: " . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        die("獲取評論結果失敗: " . mysqli_stmt_error($stmt));
    }

    if (mysqli_num_rows($result) === 0) {
        echo "沒有找到評論。";
    } else {
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
            .comment-content { color: #333; font-size: 16px; }
        </style>';

        echo '<ul>';
        while ($row = mysqli_fetch_assoc($result)) {
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
            echo '<p class="comment-content">' . $row['ReviewContent'] . '</p>';
            echo '<p> 購買的商品： ' . $row['PName'] . '</p>';
            echo '</div>';
            if ($row['img'] != NULL) {
                echo '<img class="review-image" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="Review Image" />';
            }
            echo '</li>';
        }
        echo '</ul>';

        // 分页链接
        echo '<ul class="pagination">';
        if ($page > 1) {
            echo '<li><a href="?page=' . ($page - 1) . '" class="pagination-link" style="border: none;">Previous</a></li>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<li><span class="pagination-link" style="border: none;">' . $i . '</span></li>';
            } else {
                echo '<li><a href="?page=' . $i . '" class="pagination-link" style="border: none;">' . $i . '</a></li>';
            }
        }
        if ($page < $total_pages) {
            echo '<li><a href="?page=' . ($page + 1) . '" class="pagination-link" style="border: none;">Next</a></li>';
        }
        echo '</ul>';

        echo '<script>
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
            attachPaginationEventListeners();
        </script>';
    }

} else {
    echo "未提供卖家ID。";
}
?>
