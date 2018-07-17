<?php 
	set_time_limit(0);
	$_SERVER["DOCUMENT_ROOT"] = "/var/www/html";
	include_once "common.php";
	include_once "func.sendingmail.php";
	$db->addtable("mailer");$db->awhere("status = '0' AND exec_time<=NOW()");$db->order("exec_time");$db->limit(1);
	$mailer = $db->fetch_data();
	if(isset($mailer["id"])){
		$subject = $mailer["subject"];
		$body = $mailer["body"];
		
		$db->addtable("mailer");$db->where("id",$mailer["id"]);
		$db->addfield("started_time");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("status");$db->addvalue("1");
		$db->update();
		
		if($mailer["isdebug"] == 0){//DEBUG MODE
			$debug_receivers = explode(",",$mailer["debug_receiver"]);
			foreach($debug_receivers as $debug_receiver){
				$address = str_replace(" ","",$debug_receiver);
				sendingmail("[DEBUG MODE] ".$subject,$address,$body);
				$db->addtable("mailer");$db->where("id",$mailer["id"]);$db->addfield("progressed");$db->addvalue($address);$db->update();
				sleep(2);
			}
		}
		
		if($mailer["isdebug"] == 1){//REAL MODE
			$receivers = file("mailer_recepients/".$mailer["id"].".txt");
			foreach($receivers as $receiver){
				$address = str_replace(" ","",$receiver);
				sendingmail($subject,$address,$body);
				$db->addtable("mailer");$db->where("id",$mailer["id"]);$db->addfield("progressed");$db->addvalue($address);$db->update();
				sleep(1);
			}
		}
		
		$db->addtable("mailer");$db->where("id",$mailer["id"]);
		$db->addfield("status");$db->addvalue("2");
		$db->addfield("finished_time");$db->addvalue(date("Y-m-d H:i:s"));
		$db->update();
	}
?>