<?php
include("config.php");
$id = trim(strip_tags($_POST['id']));

$type = $type == "movie" ? 1 : 2;

$q = "SELECT t.title, t.production_year, k.kind FROM title t INNER JOIN kind_type k ON k.id = t.kind_id WHERE t.id = ". $id;
$r = mysql_query($q);

if ($r) {

	$row_set = array();

	while ($row = mysql_fetch_array($r)) {
			print_r($row);	
	}

	//echo json_encode($row_set);

} else {
	echo mysql_error();
}


$q = "SELECT i.info, mi.info FROM info_type i INNER JOIN movie_info mi ON i.id = mi.info_type_id WHERE mi.movie_id = ". $id;
$r = mysql_query($q);

if ($r) {

	$row_set = array();

	while ($row = mysql_fetch_array($r)) {
			print_r($row);	
	}

	//echo json_encode($row_set);

} else {
	echo mysql_error();
}



exit;