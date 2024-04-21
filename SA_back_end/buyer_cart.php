<?php
session_start();

$link = mysqli_connect('localhost', 'root', '12345678', 'box');

if (!$link) {
    die("Error" . mysqli_connect_error());
}

$cart_id = $_SESSION['SNumber'];

$query = "SELECT product.*, `shopping cart item`.quantity FROM product 
          INNER JOIN `shopping cart item` ON product.PNumber = `shopping cart item`.PNumber
          WHERE `shopping cart item`.SNumber = $cart_id";

$result = mysqli_query($link, $query);

if (!$result) {
    die("Error: " . mysqli_error($link));
}

?>
