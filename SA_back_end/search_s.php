<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

if(isset($_POST['search'])) {
    $keyword = isset($_POST['keyword']) ? mysqli_real_escape_string($link, $_POST['keyword']) : '';

    $query = "SELECT * FROM store_info WHERE STName LIKE '%$keyword%' OR details LIKE '%$keyword%'";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("Error: " . mysqli_error($link));
    }

    echo '<div class="row mt-20">';

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $store_number = $row['STNumber']; //店家編號

            echo '<div class="col-md-4">';
            echo '<div class="product-item">';
            echo '<div class="product-thumb">';
            echo '<img class="img-set" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" alt="product-img" />';
            echo '<div class="preview-meta">';
            echo '<ul>';
            echo '<li>';
            echo '<a href="../SA_front_end/buyer_store_page.php?store_number=' . $store_number . '"><i class="tf-ion-ios-home"></i></a>'; 
            echo '</li>';
            echo '<li>';
            echo '<a href=""><i class="tf-ion-heart"></i></a>'; 
            echo '</li>';
            echo '</ul>';
            echo '</div>';
            echo '</div>';
            echo '<div class="product-content">';
            echo '<h4><a href="#">' . $row['STName'] . '</a></h4>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="col-md-12">';
        echo "找不到符合條件的店家。";
        echo '</div>';
    }

    echo '</div>'; // end of row
}
?>