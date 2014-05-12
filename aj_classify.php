<?php
include("config.php");

$id = trim(strip_tags($_POST['id']));

$total_class_countacheName = md5($id).".i2dbcache";
$dataf = array();

if (file_exists("cache/".$total_class_countacheName)) {

	//Check if the regenrate time is exceeded
	//else purge and build new cache
	if ((time() - filemtime("cache/".$total_class_countacheName)) > 60*60*12) {
		//continue to new cache generate
	} else {

		//"From Cache"
		$dataf = json_decode(file_get_contents("cache/".$total_class_countacheName), TRUE);

	}

} else {
	echo "fail";
	exit;
}

$director = explode(",", $dataf["director"]);
$budget = str_replace(" ","",str_replace("CAD","",str_replace("INR","",str_replace("$","",str_replace(",","",$dataf["budget"])))));

$test_data = array('budget'=>'20000000','genres'=>$dataf["genrescount"],'director'=>$director[1]." ".$director[0],'crewcount'=>$dataf["crewcount"]);


$all_class_labels = array();//all the classes
$indiv_class_labels = array();//all classes by group
$temp = array();

$q = "SELECT DISTINCT(label) FROM classi_labels";
$r = mysql_query($q);
while($row = mysql_fetch_array($r,MYSQL_ASSOC)) {
	$temp[] = $row;
}

foreach($temp as $tmp) {
	$all_class_labels[] = $tmp["label"];
}

$q = "SELECT COUNT(label) AS total_training_classes FROM classi_labels";
$r = mysql_query($q);
$rows = mysql_fetch_array($r,MYSQL_ASSOC);
$TOTAL_CLASS_COUNT = $rows["total_training_classes"];

foreach($all_class_labels as $acl) {
	$q = "SELECT COUNT(*) AS total_training_classes_per_class FROM classi_labels WHERE label = '".$acl."'";
	$r = mysql_query($q);
	$rows = mysql_fetch_array($r,MYSQL_ASSOC);
	$indiv_class_labels[$acl] = $rows["total_training_classes_per_class"];
}


//calculate probabilities and store them in the nbc array
foreach($indiv_class_labels as $label=>$total_class_countount) {
	$Probab_per_class[$label] = round($total_class_countount/$TOTAL_CLASS_COUNT,5);
	$nbc[$label] = 1;
}

foreach($indiv_class_labels as $key=>$value) {
	foreach($test_data as $k=>$v) {
		$q = "SELECT COUNT(*) AS num_indi FROM classi_labels WHERE label ='".$key."' AND ".$k."='".$v."'";
		$r = mysql_query($q);
		$row = mysql_fetch_array($r,MYSQL_ASSOC);

		$PaRRAY[$key][$k] = round($row["num_indi"]/$indiv_class_labels[$key],5);


		if($PaRRAY[$key][$k] != 0) {
			$nbc[$key] *= $PaRRAY[$key][$k];
		}
	}
	$nbc[$key] *= $Probab_per_class[$key];
}

$return = array_keys($nbc,max($nbc));
echo $return[0];
exit;
