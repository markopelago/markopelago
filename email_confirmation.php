<?php  
	include_once "header.php";
	$user_id = $db->fetch_single_data("a_users","id",["token" => $_GET["token"]]);
	if(!$user_id){
		$_SESSION["errormessage"] = v("email_confirmation_token_expired");
	} else {
		$db->addtable("a_users");	$db->where("id",$user_id);
		$db->addfield("token");		$db->addvalue("");
		$db->addfield("email_confirmed_at");$db->addvalue($__now);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			$users = $db->fetch_all_data("a_users",[],"id = '".$user_id."'")[0];
			$_SESSION["username"] = $users["email"];
			$_SESSION["isloggedin"] = 1;
			$_SESSION["user_id"] = $users["id"];
			$_SESSION["group_id"] = $users["group_id"];
			$_SESSION["fullname"] = $users["name"];
			
			$_SESSION["message"] = v("email_confirmed");
		} else {
			$_SESSION["errormessage"] = v("email_confirmation_failed");
		}
	}
	javascript("window.location='index.php';");
	exit();
?>