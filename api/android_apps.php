<?php
	setcookie("android_apps","1",0,"/");
	$_COOKIE["android_apps"] = 1;
	include_once "../common.php";
	$token = $_GET["token"];
	if($token != ""){	
		$users = $db->fetch_all_data("a_users",["id","group_id","name","password"],"app_token='".$token."'")[0];
		if($users["id"] > 0){
			$_SESSION["isloggedin"] = 1;
			$_SESSION["user_id"] = $users["id"];
			$_SESSION["username"] = $users["email"];
			$_SESSION["group_id"] = $users["group_id"];
			$_SESSION["fullname"] = $users["name"];
		}
	}
?>
<script>window.location="..";</script>