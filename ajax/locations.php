<?php 
	include_once "../common.php";
	$mode = $_GET["mode"];
	$suffix = $_GET["suffix"];
	if($mode == "loadCities"){
		$parent_id = $_GET["parent_id"];
		$cities = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $parent_id],["name_".$__locale],"",true);
		$name = "city_id";
		if($suffix) $name .= "_".$suffix;
		echo $f->select($name,$cities,$city_id," onchange=\"loadDistricts(this.value,'".$suffix."');\"","form-control");
	}
	if($mode == "loadDistricts"){
		$parent_id = $_GET["parent_id"];
		$districts = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $parent_id],["name_".$__locale],"",true);
		$name = "district_id";
		if($suffix) $name .= "_".$suffix;
		echo $f->select($name,$districts,$district_id,"required onchange=\"loadSubDistricts(this.value,'".$suffix."');\"","form-control");
	}	
	if($mode == "loadSubDistricts"){
		$parent_id = $_GET["parent_id"];
		$subdistricts = $db->fetch_select_data("locations","id","concat(name_".$__locale.",' [',zipcode,']')",["parent_id" => $parent_id],["name_".$__locale],"",true);
		$name = "subdistrict_id";
		if($suffix) $name .= "_".$suffix;
		echo $f->select($name,$subdistricts,$subdistrict_id,"required","form-control");
	}	
?>