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


$total = array();
$simIlarity_total = array();
$iranks = array();
$distmeasure = 0;

$movies_user_ratings = $nfilms;
$person = $_COOKIE["email"];

foreach($movies_user_ratings as $eachuSer=>$values) {
    if($eachuSer != $person) {
        $distmeasure = simil_dist($movies_user_ratings, $person, $eachuSer);
        $distmeasure = 1/$distmeasure;
    }
    
    if($distmeasure > 0) {
        foreach($movies_user_ratings[$eachuSer] as $key=>$value) {
            if(!array_key_exists($key, $movies_user_ratings[$person])) {
                if(!array_key_exists($key, $total)) {
                    $total[$key] = 0;
                }
                $total[$key] += $movies_user_ratings[$eachuSer][$key] * $distmeasure;
                if(!array_key_exists($key, $simIlarity_total)) {
                    $simIlarity_total[$key] = 0;
                }
                $simIlarity_total[$key] += $distmeasure;
            }
        }
        
    }
}
foreach($total as $key=>$value){
    $iranks[$key] = $value / $simIlarity_total[$key];
}
array_multisort($iranks, SORT_DESC);    

$recommendations = $iranks;

$finalReturn = array();

foreach ($recommendations as $k=>$v) {
	$returnSet["movie"] = $k;
	$returnSet["score"] = $v;
	$returnSet["itemid"] = $filmsDet[$k];
	$finalReturn[] = $returnSet;
}
echo json_encode($finalReturn);
?>