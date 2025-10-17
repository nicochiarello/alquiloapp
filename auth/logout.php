<?php
session_start();
session_destroy();
header("Location: /alquiloapp/login.php");
exit;

?>