<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$link = mysqli_connect('localhost', 'root', '12345678', 'box');
if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

$limit = 3;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page <= 0) $page = 1;

$offset = ($page - 1) * $limit;

if (isset($_SESSION['user_id'])) {
    $seller_id = $_SESSION['user_id'];

    // 獲取店鋪編號
    $store_query = "SELECT STNumber FROM store_info WHERE seller_ID = ?";
    $store_stmt = mysqli_prepare($link, $store_query);
    if (!$store_stmt) {
        die("準備查詢店鋪編號失敗: " . mysqli_error($link));
    }
    mysqli_stmt_bind_param($store_stmt, "i", $seller_id);
    mysqli_stmt_execute($store_stmt);
    $store_result = mysqli_stmt_get_result($store_stmt);
    if (!$store_result || mysqli_num_rows($store_result) == 0) {
        die("未找到該賣家的店鋪: " . mysqli_stmt_error($store_stmt));
    }
    $store_info = mysqli_fetch_assoc($store_result);
    $st_number = $store_info['STNumber'];

    // 獲取評論總數
    $count_query = "SELECT COUNT(*) as total FROM review WHERE STNumber = ?";
    $count_stmt = mysqli_prepare($link, $count_query);
    if (!$count_stmt) {
        die("準備查詢總評論數失敗: " . mysqli_error($link));
    }
    mysqli_stmt_bind_param($count_stmt, "i", $st_number);
    mysqli_stmt_execute($count_stmt);
    $count_result = mysqli_stmt_get_result($count_stmt);
    $total_reviews = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_reviews / $limit);

    // 獲取評論
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
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        echo "沒有找到評論。";
    } else {
        echo '<ul>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li class="media">';
            echo '<div class="media-left">';
            echo '<div class="circular-avatar">';
            echo '<img class="media-object comment-avatar" src="data:image/jpeg;base64,' . base64_encode($row['buyer_img']) . '" alt="" style="width: 100%; height: 100%; object-fit: cover;" />';
            echo '</div>';
            echo '<button class="reply-button" data-toggle="modal" data-target="#reply-modal" data-reviewid="' . $row['ReviewID'] . '">回覆</button>';
            echo '</div>';
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
        
            // 印出回覆
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
        }
        echo '</ul>';

        // 分頁導航
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
                    var reviewID = document.getElementById("replyReviewID").value; // 在翻頁前先保存當前的 ReviewID
        
                    fetch(url)
                        .then(response => response.text())
                        .then(data => {
                            document.body.innerHTML = data;
                            window.scrollTo(0, scrollPosition);
                            document.getElementById("replyReviewID").value = reviewID; // 在翻頁後恢復當前的 ReviewID
                            attachReplyButtonListeners(); // 在每次頁面更新後重新綁定回覆按鈕事件
                            attachPaginationEventListeners(); // 在每次頁面更新後重新綁定翻頁按鈕事件
                        });
                });
            });
        }
    
        function attachReplyButtonListeners() {
            document.querySelectorAll(".reply-button").forEach(button => {
                button.addEventListener("click", function() {
                    var reviewID = this.getAttribute("data-reviewid");
                    document.getElementById("replyReviewID").value = reviewID;
                });
            });
        }
    
        document.addEventListener("DOMContentLoaded", function() {
            attachPaginationEventListeners(); // 頁面第一次加載時綁定翻頁按鈕事件
            attachReplyButtonListeners(); // 頁面第一次加載時綁定回覆按鈕事件
        });
    </script>';
    

        // 回覆模態框
        echo '<div class="modal fade" id="reply-modal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">';
        echo '  <div class="modal-dialog" role="document">';
        echo '    <div class="modal-content">';
        echo '      <div class="modal-header">';
        echo '        <h5 class="modal-title" id="replyModalLabel">回覆評論</h5>';
        echo '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        echo '          <span aria-hidden="true">&times;</span>';
        echo '        </button>';
        echo '      </div>';
        echo '      <div class="modal-body">';
        echo '        <form action="../SA_back_end/seller_reply.php" method="post">';
        echo '          <div class="form-group">';
        echo '            <label for="replyContent">輸入內容</label>';
        echo '            <textarea class="form-control" id="replyContent" name="replyContent" rows="3" required></textarea>';
        echo '          </div>';
        echo '          <input type="hidden" id="replyReviewID" name="reviewID" value="">';
        echo '          <button type="submit" class="btn btn-primary">提交</button>';
        echo '        </form>';
        echo '      </div>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }
}
mysqli_close($link);
?>
