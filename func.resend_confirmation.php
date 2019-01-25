<?php
	if(isset($_GET["resend_confirmation_link"])){
		$email = $__user["email"];
		$phone = $__user["phone"];
		$token = randtoken(15).base64_encode("_signup_".$__user_id);
		$db->addtable("a_users");	$db->where("id",$__user_id);
		$db->addfield("token");		$db->addvalue($token);
		$db->update();
		
		$arr1 = ["{link}"];
		$arr2 = ["https://www.markopelago.com/email_confirmation.php?token=".$token];
		$body = read_file("html/email_signup_confirmation_id.html");
		$body = str_replace($arr1,$arr2,$body);
		sendingmail("Markopelago.com -- Email Konfirmasi",$email,$body,"system@markopelago.com|Markopelago System");
		
		$arr1 = ["{link}"];
		$arr2 = ["https://www.markopelago.com/phone_confirmation.php?token=".$token];
		$message = v("sms_signup_confirmation");
		$message = str_replace($arr1,$arr2,$message);
		$db->addtable("sms_queue");
		$db->addfield("msisdn");	$db->addvalue($phone);
		$db->addfield("message");	$db->addvalue($message);
		$db->insert();
		
		$_SESSION["message"] = v("resend_confirmation_link_success");
		javascript("window.location='?';");
		exit();
	}
?>