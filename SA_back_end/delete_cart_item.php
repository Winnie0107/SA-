<?php
session_start();

if (isset($_POST['SINumber'])) {
    $SINumber = $_POST['SINumber'];
    $link = mysqli_connect('localhost', 'root', '12345678', 'box');

    if (!$link) {
        die("Error" . mysqli_connect_error());
    }

    $delete_cart_item = "DELETE FROM `shopping cart item` WHERE SINumber = ?";
    $stmt = mysqli_prepare($link, $delete_cart_item);
    mysqli_stmt_bind_param($stmt, "i", $SINumber);

    if (mysqli_stmt_execute($stmt)) {

        $cart_id = $_SESSION['SNumber'];
        $query = "SELECT * FROM `shopping cart item` JOIN product ON `shopping cart item`.PNumber = product.PNumber WHERE SNumber = $cart_id";
        $result = mysqli_query($link, $query);

        if (!$result) {
            die("Error" . mysqli_error($link));
        }


        header("Location: http://localhost/SA-/SA_front_end/buyer_cart.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>