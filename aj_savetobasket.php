<?php
include("config.php");
$type = trim(strip_tags($_POST['type'])) == "movie" ? 1 : 2;
$value = trim(strip_tags($_POST['value']));
$id = trim(strip_tags($_POST['id']));
$q = "INSERT INTO usertable (username,type,itemid,itemname) VALUES ('".$_COOKIE["email"]."', ".$type.",".$id.",'".$value."')";
if (mysql_query($q)) {
	echo "1";
} else {
	echo mysql_error();
}
exit;