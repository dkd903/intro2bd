<?php

//vulnerability where only email cookie ius cleared 
//to logout user
//the credit card cookie and expiry cookie is left out
//allowing next user to use other user's cc info
include("config.php");
setcookie ("email", "", time() - 3600);

//setcookie ("cc", "", time() - 3600);
//setcookie ("cctype", "", time() - 3600);
//setcookie ("cvv", "", time() - 3600);
//setcookie ("expiry", "", time() - 3600);

header("Location:http://".$site);
?>