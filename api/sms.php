<?php
	include_once "../common.php";
	include_once "user_info.php";
	$mode = $_GET["mode"];
	if($mode == "outqueue"){
		$sms_queues = $db->fetch_all_data("sms_queue",[],"xstatus=0 ORDER BY id LIMIT 3");
		if(count($sms_queues) > 0){
			echo "sms_outqueue}}}";
			foreach($sms_queues as $sms_queue){
				echo $sms_queue["id"]."|||".$sms_queue["msisdn"]."|||".$sms_queue["message"]."}}}";
			}
		}
	}
	if($mode == "sms_sent"){
		$ids = substr($_GET["ids"],0,-1);
		$db->addtable("sms_queue");	$db->where("id",$ids,"s","IN");
		$db->addfield("xstatus");	$db->addvalue("1");
		$db->addfield("sent_at");	$db->addvalue($__now);
		$db->update();
		echo "sms_sent_updated}}}";
	}
?>