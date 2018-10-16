<?php
	$token = $_GET["token"];
	if($token != ""){		
		$username = $db->fetch_single_data("a_users","email",["app_token" => $token]);
		$user_id = $db->fetch_single_data("a_users","id",["app_token" => $token]);
		$group_id = $db->fetch_single_data("a_users","group_id",["app_token" => $token]);
		$__username = $username;
		$_SESSION["username"] = $username;
		$__user_id = $user_id;
		$__group_id = $group_id;
	}
?>