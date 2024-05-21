<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['SINumber']) && !empty($_POST['SINumber'])) {
        $SINumber = mysqli_real_escape_string($link, $_POST['SINumber']);

        $delete_query = "DELETE FROM `shopping cart item` WHERE SINumber = '$SINumber'";

        $delete_result = mysqli_query($link, $delete_query);

        if (!$delete_result) {
            die("Error: " . mysqli_error($link));
        } else {
            header("Location: ../SA_front_end/buyer_cart.php");
            exit();
        }
    } else {
        die("Error: SINumber is not set or is empty.");
    }
}

mysqli_close($link);
?>
