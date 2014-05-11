<?php
include("config.php");
$list = $_POST['list'];

//movie info

$q = "SELECT i.info, mi.info FROM info_type i 
				INNER JOIN movie_info mi ON i.id = mi.info_type_id 
				WHERE ( i.info = 'genres' ) AND mi.movie_id IN (". implode(",",$list) .")";
$r = mysql_query($q);

$genreInfo = array();
$genreInfoF = array();
$genreInfoFSet = array();

if ($r) {

	$row_set = array();
	$genreInfo = array();
	while ($row = mysql_fetch_array($r)) {

		if ($row[0] == "genres") {

			if (!isset($genreInfo[$row[1]])) $genreInfo[$row[1]] = 0;
			$genreInfo[$row[1]]++; 

		}

	}

	foreach($genreInfo as $k=>$v) {
		$genreInfoF["genre"] = $k;
		$genreInfoF["value"] = $v;
		$genreInfoFSet[] = $genreInfoF;
	}
	
	echo(json_encode($genreInfoFSet));

} else {
	echo mysql_error();
}

exit;