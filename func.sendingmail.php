<?php

function sendingmail($subject,$address,$body,$replyto = "cs@markopelago.com|Customer Service markopelago.com") {
	global $db,$__username,$_SERVER;
	$db->addtable("mail_queue");
	$db->addfield("subject");$db->addvalue(str_replace("'","''",$subject));
	$db->addfield("address");$db->addvalue($address);
	$db->addfield("body");$db->addvalue(base64_encode($body));
	$db->addfield("replyto");$db->addvalue($replyto);
	$arr = $db->insert();
}

?>