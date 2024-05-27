<?php
session_start();
$_SESSION=array();
session_destroy();
header("Location:../SA_front_end/index.php");
?>
