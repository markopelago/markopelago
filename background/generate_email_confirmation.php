<?php
	include_once "common.php";
	include_once "../func.sendingmail.php";
	$users = $db->fetch_all_data("a_users",[],"date(email_confirmed_at) = '0000-00-00' AND token=''");
	foreach($users as $user){
		echo $user["id"]."<br>";
		$token = randtoken(15).base64_encode("_signup_".$user["email"]);
		$db->addtable("a_users");	$db->where("id",$user["id"]);
		$db->addfield("token");		$db->addvalue($token);
		$db->update();
		$arr1 = ["{link}"];
		$arr2 = ["https://www.markopelago.com/email_confirmation.php?token=".$token];
		$body = read_file("../html/email_signup_confirmation_id.html");
		$body = str_replace($arr1,$arr2,$body);
		sendingmail("Markopelago.com -- Email Konfirmasi",$user["email"],$body,"system@markopelago.com|Markopelago System");
	}
?>