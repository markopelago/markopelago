<?php 
	include_once "../common.php";
	$agency_model_id = $_GET["agency_model_id"];
	$join_status = $_GET["join_status"];
	$db->addtable("agency_models");$db->where("id",$agency_model_id);$db->where("agency_user_id",$__user_id);
	$db->addfield("join_status");	$db->addvalue($join_status);
	$db->addfield("join_at");		$db->addvalue($__now);
	$updating = $db->update();
	if($updating["affected_rows"] > 0){
		if($join_status == "2"){
			$message = v("success_message_accept_join_request");
			$return = "alreadyMember";
		}
		if($join_status == "3"){
			$message = v("success_message_reject_join_request");
			$return = "joinRequests";
		}
		$model_user_id = $db->fetch_single_data("agency_models","model_user_id",["id" => $agency_model_id]);
		$modelName = $db->fetch_single_data("model_profiles","concat(first_name,' ',middle_name,' ',last_name)",["user_id" => $model_user_id]);
		$_SESSION["message"] = str_replace("{modelName}",$modelName,$message);
		echo $return;
	}else{
		$_SESSION["errormessage"] = "Failed updating data!";
	}
?>