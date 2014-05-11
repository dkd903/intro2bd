<?php
include("config.php");
setcookie ("email", "", time() - 3600);
setcookie("email",strtolower($_GET["user"]));
header("Location:http://".$site);
?>