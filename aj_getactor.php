<?php
include("config.php");
$id = trim(strip_tags($_POST['id']));

$cacheName = "actor_".md5($id).".i2dbcache";

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

//person title

$q = "SELECT name.name, name.gender FROM name WHERE name.id = ". $id;
$r = mysql_query($q);

if ($r) {

	$row_set = array();

	while ($row = mysql_fetch_array($r)) {
			
			$dataSaved["name"]	= $row["name"];
			$dataSaved["gender"]	= $row["gender"];
	}

} else {
	echo mysql_error();
}

//person roles in various movies

$q = "SELECT role FROM role_type WHERE id IN ( SELECT distinct(role_id) FROM cast_info WHERE person_id = ". $id . ")";
$r = mysql_query($q);

if ($r) {

	$row_set = array();

	while ($row = mysql_fetch_array($r)) {
			
			$roles[] = $row["role"];

	}

	$dataSaved["roles"] = implode(", ", $roles);

} else {
	echo mysql_error();
}

//movie info of person

$q = "SELECT title.id, title.title, title.production_year FROM title 
				INNER JOIN cast_info ON cast_info.movie_id = title.id  
				WHERE cast_info.person_id = ". $id ." AND 
				title.production_year < 2015 ORDER BY title.production_year DESC";
$r = mysql_query($q);

$actor = array();

if ($r) {

	$row_set = array();

	while ($row = mysql_fetch_array($r)) {

			$movies[] = array("itemid" => $row["id"], "title" => $row["title"], "production_year" => $row["production_year"]);
	}

	$dataSaved["movies"] = $movies;

} else {
	echo mysql_error();
}

//person info

$q = "SELECT i.info, pi.info FROM info_type i 
				INNER JOIN person_info pi ON i.id = pi.info_type_id 
				WHERE ( i.info = 'birth date' OR i.info = 'height' 
					OR i.info = 'mini biography') 
					AND pi.person_id = ". $id;
$r = mysql_query($q);

if ($r) {

	$row_set = array();
	$genreInfo = array();
	while ($row = mysql_fetch_array($r)) {

		if ($row[0] == "mini biography") {
			$dataSaved["bio"] =  $row[1];
		}

		if ($row[0] == "birth date") {
			$dataSaved["dob"] =  $row[1];
		}

		if ($row[0] == "height") {
			$dataSaved["height"] =  $row[1];
		}

	}

} else {
	echo mysql_error();
}

echo $outSave = json_encode($dataSaved);

if(file_put_contents("cache/".$cacheName, $outSave)) {

} else {
	echo "Fail";
}

exit;