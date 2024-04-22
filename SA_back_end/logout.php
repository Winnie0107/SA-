<?php
session_start();

$keep_variables = array('user_account', 'user_level');

foreach ($_SESSION as $key => $value) {
    if (!in_array($key, $keep_variables)) {
        unset($_SESSION[$key]);
    }
}

session_destroy();

header("Location:../SA_front_end/index.php");
?>
