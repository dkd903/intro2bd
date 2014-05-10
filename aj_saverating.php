<?php
include("config.php");
$rating = trim(strip_tags($_POST['rating']));
$id = trim(strip_tags($_POST['id']));
$q = "UPDATE usertable SET rate = ".$rating." WHERE id = ".$id. " AND username = '".$_COOKIE["email"]."'";
if (mysql_query($q)) {
	echo "1";
} else {
	echo mysql_error();
}
exit;