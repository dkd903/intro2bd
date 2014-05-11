<?php
include("config.php");
//actors director genres budget

$q = "DELETE FROM classi_labels";
$r = mysql_query($q);

echo $q = "SELECT i.info, mi.info,mi.movie_id FROM info_type i 
				INNER JOIN movie_info mi ON i.id = mi.info_type_id 
				WHERE ( i.info = 'genres' OR i.info = 'budget' ) AND mi.movie_id IN 
					(SELECT distinct(itemid) FROM usertable 
					WHERE type = 1)";
$r = mysql_query($q);
$data = array();
while ($row = mysql_fetch_array($r)) {
	if ($row[0] == "budget") {
		$data[$row["movie_id"]]["budget"] = str_replace(" ","",str_replace("CAD","",str_replace("INR","",str_replace("$","",str_replace(",","",$row["info"])))));
	}
	if ($row[0] == "genres") {
		if (!isset($data[$row["movie_id"]]["genres"])) $data[$row["movie_id"]]["genres"] = 0;
		$data[$row["movie_id"]]["genres"]++;
	}
}

foreach ($data as $k=>$v) {
	if (!isset($data[$k]["budget"])) {
		$data[$k]["budget"] = rand(17, 35)*000000;
	} else if ($data[$k]["budget"] == 0) {
		$data[$k]["budget"] = rand(17, 35)*000000;
	}
}

//print_r($data);

$q = "SELECT name.id, name.name, name.gender, role_type.role, cast_info.movie_id FROM name 
				INNER JOIN cast_info ON cast_info.person_id = name.id 
				INNER JOIN role_type ON cast_info.role_id = role_type.id 
				WHERE cast_info.movie_id IN 
					(SELECT distinct(itemid) FROM usertable 
					WHERE type = 1)";
$r = mysql_query($q);

while ($row = mysql_fetch_array($r)) {
	if ($row["role"] == "director") {
		$name = explode(",", $row["name"]);
		$data[$row["movie_id"]]["director"] = $name[1]." ".$name[0];
	} else {
		if (!isset($data[$row["movie_id"]]["crewcount"])) $data[$row["movie_id"]]["crewcount"] = 0;
		$data[$row["movie_id"]]["crewcount"]++;
	}
}

foreach ($data as $k=>$v) {
	echo $q = "INSERT INTO classi_labels VALUES (NULL,".$k.",".$v['budget'].",".$v['genres'].",'".$v['director']."',".$v['crewcount'].",".rand(1,5).")";
	mysql_query($q);
}