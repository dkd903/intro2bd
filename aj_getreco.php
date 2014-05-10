<?php

include("config.php");
require_once("functions.php");
//require_once("sample_list.php");

$type = trim(strip_tags($_POST['type']));
$type = $type == "movies" ? 1 : 2;

$q = "SELECT * FROM usertable WHERE rate > 0 AND type = " . $type;
$r = mysql_query($q);

$films = array();
$filmsDet = array();

if ($r) {
	while ($row = mysql_fetch_array($r)) {
		//print_r($row);
		$films[$row["username"]][] = array($row["itemname"] => $row["rate"]);
		$filmsDet[$row["itemname"]] = $row["itemid"];
	}
} else {
	echo mysql_error();
}

$nfilms = array();
foreach ($films as $key=>$value) {
	$temp = array();
	foreach ($value as $k => $v) {
		foreach ($v as $ksub => $vsub) {
			$temp[$ksub] = $vsub;
		}
	}
	$nfilms[$key] = $temp;
}
$recommendations = getRecommendations($nfilms, $_COOKIE["email"]);

$finalReturn = array();

foreach ($recommendations as $k=>$v) {
	$returnSet["movie"] = $k;
	$returnSet["score"] = $v;
	$returnSet["itemid"] = $filmsDet[$k];
	$finalReturn[] = $returnSet;
}
echo json_encode($finalReturn);
?>