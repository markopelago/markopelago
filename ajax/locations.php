<?php 
	include_once "../common.php";
	$mode = $_GET["mode"];
	if($mode == "loadCities"){
		$parent_id = $_GET["parent_id"];
		$cities = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $parent_id],["name_".$__locale],"",true);
		echo $f->select("city_id",$cities,$city_id," onchange=\"loadDistricts(this.value);\"","form-control");
	}
	if($mode == "loadDistricts"){
		$parent_id = $_GET["parent_id"];
		$districts = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $parent_id],["name_".$__locale],"",true);
		echo $f->select("district_id",$districts,$district_id,"required onchange=\"loadSubDistricts(this.value);\"","form-control");
	}	
	if($mode == "loadSubDistricts"){
		$parent_id = $_GET["parent_id"];
		$subdistricts = $db->fetch_select_data("locations","id","concat(name_".$__locale.",' [',zipcode,']')",["parent_id" => $parent_id],["name_".$__locale],"",true);
		echo $f->select("subdistrict_id",$subdistricts,$subdistrict_id,"required","form-control");
	}	
?>