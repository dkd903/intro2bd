<?php
include("config.php");
$id = trim(strip_tags($_POST['id']));

$cacheName = md5($id).".i2dbcache";

if (file_exists("cache/".$cacheName)) {

	//Check if the regenrate time is exceeded
	//else purge and build new cache
	if ((time() - filemtime("cache/".$cacheName)) > 60*60*12) {
		//continue to new cache generate
	} else {

		//"From Cache"
		echo file_get_contents("cache/".$cacheName);
		exit;

	}
}

$dataSaved = array();

//movie title

$q = "SELECT t.title, t.production_year, k.kind FROM title t 
		INNER JOIN kind_type k ON k.id = t.kind_id WHERE t.id = ". $id;
$r = mysql_query($q);

if ($r) {

	$row_set = array();

	while ($row = mysql_fetch_array($r)) {
			//print_r($row);
			$dataSaved["title"]	= $row["title"];
			$dataSaved["production_year"]	= $row["production_year"];
			$dataSaved["type"]	= $row["kind"];

	}

} else {
	echo mysql_error();
}

//cast info

$q = "SELECT name.id, name.name, name.gender, role_type.role FROM name 
				INNER JOIN cast_info ON cast_info.person_id = name.id 
				INNER JOIN role_type ON cast_info.role_id = role_type.id 
				WHERE cast_info.movie_id = ". $id;
$r = mysql_query($q);

$actor = array();

if ($r) {

	$row_set = array();

	while ($row = mysql_fetch_array($r)) {

			$actor[] = array("pid" => $row["id"], "name" => $row["name"], "gender" => $row["gender"], "role" => $row["role"]);
	}

	$dataSaved["actors"] = $actor;

} else {
	echo mysql_error();
}

//movie info

$q = "SELECT i.info, mi.info FROM info_type i 
				INNER JOIN movie_info mi ON i.id = mi.info_type_id 
				WHERE ( i.info = 'runtimes' OR i.info = 'genres' 
					OR i.info = 'taglines' OR i.info = 'votes' 
					OR i.info = 'budget' )AND mi.movie_id = ". $id;
$r = mysql_query($q);

if ($r) {

	$row_set = array();
	$genreInfo = array();
	while ($row = mysql_fetch_array($r)) {

		if ($row[0] == "genres") {
			array_push($genreInfo, $row[1]);
		}

		if ($row[0] == "taglines") {
			$dataSaved["tagline"] =  $row[1];
		}

		if ($row[0] == "budget") {
			$dataSaved["budget"] =  $row[1];
		}

	}

	$dataSaved["genres"] = $genreInfo;

	//print_r($dataSaved);

} else {
	echo mysql_error();
}

echo $outSave = json_encode($dataSaved);

if(file_put_contents("cache/".$cacheName, $outSave)) {

} else {
	echo "Fail";
}

exit;