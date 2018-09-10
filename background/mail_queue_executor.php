<?php
	set_time_limit(0);
	include_once "document_root_path.php";
	include_once "../func.sendingmail_v2.php";
	include_once "common.php";
	
	$db->addtable("mail_queue");
	$db->where("status",0);
	$db->order("id");
	$db->limit(50);
	foreach($db->fetch_data(true) as $mail_queue){
		$subject = $mail_queue["subject"];
		$body = base64_decode($mail_queue["body"]);
		$address = $mail_queue["address"];
		$replyto = $mail_queue["replyto"];
		
		sendingmail($subject,$address,$body,$replyto);
		$db->addtable("mail_queue");
		$db->where("id",$mail_queue["id"]);
		$db->addfield("status");$db->addvalue(1);
		$db->update();
	}

?>