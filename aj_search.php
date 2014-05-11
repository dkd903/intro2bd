<?php
include("config.php");
$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

if ($_GET["datasource"] == "movie") {

	$qstring = "SELECT title,id,production_year FROM title WHERE title LIKE '%".$term."%' 
		AND production_year != '' AND kind_id = 1 AND production_year <=2014 
		ORDER BY production_year DESC";
	$result = mysql_query($qstring);//query the database for entries containing the term

	while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
	{
			$row['value']=htmlentities(stripslashes($row['title']." (". $row['production_year'] .")"));
			$row['id']=(int)$row['id'];
			$row_set[] = $row;//build an array
	}

} else if ($_GET["datasource"] == "actor") {

	$qstring = "SELECT name, id FROM name WHERE name LIKE '%".$term."%' ORDER BY name ASC";
	$result = mysql_query($qstring);//query the database for entries containing the term

	while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
	{
			$row['value']=htmlentities(stripslashes($row['name']));
			$row['id']=(int)$row['id'];
			$row_set[] = $row;//build an array
	}

}
echo json_encode($row_set);//format the array into json data