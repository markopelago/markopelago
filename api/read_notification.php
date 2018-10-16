<?php
	$_COOKIE["android_apps"] = 1;
	include_once "../common.php";
	include_once "user_info.php";
	if($__user_id > 0){
		$notifications = $db->fetch_all_data("notifications",[],"user_id = '".$__user_id."' AND status='0'");
		foreach($notifications as $notification){
			echo $notification["id"]."|||".$notification["message"]."]]]";
		}
		$db->addtable("notifications");
		$db->where("user_id",$__user_id);
		$db->where("status","0");
		$db->addfield("status");$db->addvalue(1);
		$db->update();
	}
?>