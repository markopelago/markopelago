<?php 
	include_once "../common.php";
	$id = $_GET["id"];
	$mode = $_GET["mode"];
	if($mode == "apply"){
		$result = $js->apply_job($__user_id,$id);
		if(($result*1) > 0){
			$thread_id = $db->fetch_single_data("messages","thread_id",["user_id" => $user_id],["thread_id DESC"]);
			$thread_id++;
			$modelName = $db->fetch_single_data("model_profiles","concat(first_name,' ',middle_name,' ',last_name)",["user_id" => $__user_id]);
			$jobsTitle = $db->fetch_single_data("jobs","title",["id" => $id]);
			$job_giver_user_id = $db->fetch_single_data("jobs","job_giver_user_id",["id" => $id]);
			$message = str_replace(["{modelName}","{jobsTitle}"],[$modelName,$jobsTitle],v("notification_success_model_apply_job"));
			$db->addtable("messages");
			$db->addfield("thread_id");		$db->addvalue($thread_id);
			$db->addfield("user_id");		$db->addvalue(0);
			$db->addfield("user_id2");		$db->addvalue($job_giver_user_id);
			$db->addfield("message");		$db->addvalue($message);
			$db->insert();
		}
		echo $result;
	}
	if($mode == "isApplied"){
		if($db->fetch_single_data("jobs","job_giver_user_id",["id"=>$id]) == $__user_id) echo "0";
		echo $js->is_applied($__user_id,$id);
	}
	if($mode == "delete"){
		$db->addtable("jobs"); $db->where("id",$id); $db->where("job_giver_user_id",$__user_id);
		$db->delete_();
		$_SESSION["message"] = v("success_message_delete_job");
		echo "1";
	}
?>