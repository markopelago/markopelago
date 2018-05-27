<?php
function login_action($username,$password){
	global $_SERVER,$_SESSION,$db,$_POST,$v;
	$db->addtable("a_users");
	$db->addfield("id");
	$db->addfield("group_id");
	$db->addfield("password");
	$db->addfield("name");
	$db->addfield("role");
	$db->addfield("sign_in_count");
	$db->addfield("current_sign_in_at");
	$db->addfield("last_sign_in_at");
	$db->addfield("current_sign_in_ip");
	$db->addfield("last_sign_in_ip");
	$db->where("email",$username);
	$db->limit(1);
	$users = $db->fetch_data();
	if($users["id"] > 0){
		if($users["password"] == base64_encode($password)){
			$_SESSION["errormessage"] = "";
			$_SESSION["username"] = $username;
			$_SESSION["isloggedin"] = 1;
			$_SESSION["user_id"] = $users["id"];
			$_SESSION["group_id"] = $users["group_id"];
			$_SESSION["fullname"] = $users["name"];
			$_SESSION["is_seeker"] = true;
			$_SESSION["role"] = $users["role"];
			
			$db->addtable("a_users"); 
			$db->where("id",$users["id"]);
			$db->addfield("sign_in_count");$db->addvalue($users["sign_in_count"] + 1);
			$db->addfield("current_sign_in_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("last_sign_in_at");$db->addvalue($users["current_sign_in_at"]);
			$db->addfield("current_sign_in_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->addfield("last_sign_in_ip");$db->addvalue($users["current_sign_in_ip"]);
			$db->update(); 
			
			$db->addtable("a_log_histories"); 
			$db->addfield("user_id");$db->addvalue($users["id"]);
			$db->addfield("email");$db->addvalue($username);
			$db->addfield("x_mode");$db->addvalue(1);
			$db->addfield("log_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("log_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->insert(); 

			return 1;
		} else {
			$_SESSION["errormessage"] = v("error_wrong_username_password");
			return 0;
		}
	} else {
		$_SESSION["errormessage"] = v("error_wrong_username_password");
		return 0;
	}
	return 0;
}


if(isset($_GET["logout_action"])){
	
	$db->addtable("a_log_histories"); 
	$db->addfield("user_id");$db->addvalue($__user_id);
	$db->addfield("email");$db->addvalue($__username);
	$db->addfield("x_mode");$db->addvalue(2);
	$db->addfield("log_at");$db->addvalue(date("Y-m-d H:i:s"));
	$db->addfield("log_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
	$db->insert(); 
	
	$_SESSION=array();
	session_destroy();
	
	?> <script language="javascript"> window.location='index.php'; </script><?php
}
if(isset($_POST["login_action"])){
	$_login_action = login_action($_POST["username"],$_POST["password"]);
	if($_login_action > 0) {
		$_SESSION["message"] = v("signin_success");
		?> <script language="javascript">window.location="index.php";</script><?php
		exit();
	}
}
?>