<?php
include("config.php");
$type = trim(strip_tags($_POST['type']));
$type = $type == "movie" ? 1 : 2;

$q = "SELECT * FROM usertable WHERE username = '".$_COOKIE["email"]."' AND type = ".$type ;
$r = mysql_query($q);

if ($r) {

	$row_set = array();

	while ($row = mysql_fetch_array($r)) {
			//print_r($row);
			$rowf['value']=htmlentities(stripslashes($row['itemname']));
			$rowf['itemid']=(int)$row['itemid'];
			$rowf['id']=(int)$row['id'];
			$rowf['rating']=(int)$row['rate'];
			$row_set[] = $rowf;//build an array		
	}

	echo json_encode($row_set);

} else {
	echo mysql_error();
}
exit;