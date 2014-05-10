<?php
include("config.php");
setcookie ("email", "", time() - 3600);
header("Location:http://".$site);
?>