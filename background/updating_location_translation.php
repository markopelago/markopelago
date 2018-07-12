<?php
	include_once "document_root_path.php";
	include_once "common.php";
	$locations_translation = $db->fetch_all_data("locations_translation",[]);
	foreach($locations_translation as $_locations_translation){
		$sql = "UPDATE surveys SET location_id = '".$_locations_translation["new_id"]."' WHERE location_id = '".$_locations_translation["old_id"]."';";
		echo $sql.$__enter;
	}
	echo "UPDATE surveys SET location_id = '2032' WHERE location_id = '3';".$__enter;
?>
