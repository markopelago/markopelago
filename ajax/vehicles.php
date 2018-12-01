<?php 
	include_once "../common.php";
	$mode = $_GET["mode"];
	if($mode == "change_is_active"){
		$vehicle_id = $_GET["vehicle_id"];
		$value = $_GET["value"];
		if($value == "true"){
			$db->addtable("forwarder_vehicles");
			$db->where("id",$vehicle_id);
			$db->addfield("is_active");	$db->addvalue(1);
			if($db->update()["affected_rows"] > 0) echo "<font color='#2196F3'>".v("active")."</font>";
		}
		if($value == "false"){
			$db->addtable("forwarder_vehicles");
			$db->where("id",$vehicle_id);
			$db->addfield("is_active");	$db->addvalue(0);
			if($db->update()["affected_rows"] > 0) echo "<font color='red'>".v("not_active")."</font>";
		}
	}
	if($mode == "change_is_route_active"){
		$route_id = $_GET["route_id"];
		$value = $_GET["value"];
		if($value == "true"){
			$db->addtable("forwarder_routes");
			$db->where("id",$route_id);
			$db->addfield("is_active");	$db->addvalue(1);
			if($db->update()["affected_rows"] > 0) echo "<font color='#2196F3'>".v("active")."</font>";
		}
		if($value == "false"){
			$db->addtable("forwarder_routes");
			$db->where("id",$route_id);
			$db->addfield("is_active");	$db->addvalue(0);
			if($db->update()["affected_rows"] > 0) echo "<font color='red'>".v("not_active")."</font>";
		}
	}
?>