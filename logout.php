<?php
session_start();
unset($_SESSION["use"]);
unset($_SESSION["user_type"]);
header("Location:login.php");
?>