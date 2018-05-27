<?php
function gethttp_value($url){
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function sendingmail($subject,$address,$body,$replyto = "cs@jalurkerja.com|Customer Service JalurKerja.com") {
	require_once("phpmailer/class.phpmailer.php");
	include_once("phpmailer/class.smtp.php");
	$domain = explode("@",$address);
	$_server = gethttp_value("http://103.253.113.164/api/smtp_notes.php?mode=available&domain=".$domain[1]) * 1;
	if($_server == 0){
		$pause = (70 - date("i")) * 60;
		sleep($pause);
		$_server = gethttp_value("http://103.253.113.164/api/smtp_notes.php?mode=available&domain=".$domain[1]) * 1;
	}

	$config[1]["secure"] = "";
	$config[2]["secure"] = "ssl";
	$config[3]["secure"] = "ssl";
	$config[4]["secure"] = "ssl";
	$config[5]["secure"] = "tls";
	$config[6]["secure"] = "ssl";
	$config[7]["secure"] = "ssl";
	$config[8]["secure"] = "";

	$config[1]["host"] = "localhost";
	$config[2]["host"] = "iix78.rumahweb.com";
	$config[3]["host"] = "merapi.rumahweb.com";
	$config[4]["host"] = "sindoro.indowebhoster.com";
	$config[5]["host"] = "smtp.gmail.com";
	$config[6]["host"] = "server1.jalurkerja.net";
	$config[7]["host"] = "103.253.113.165";
	$config[8]["host"] = "103.253.113.164";
	
	$config[1]["port"] = 25;
	$config[2]["port"] = 465;
	$config[3]["port"] = 465;
	$config[4]["port"] = 465;
	$config[5]["port"] = 587;
	$config[6]["port"] = 465;
	$config[7]["port"] = 465;
	$config[8]["port"] = 25;

	$config[1]["username"] = "";
	$config[2]["username"] = "cs@jalurkerja.com";
	$config[3]["username"] = "mailer@bluefish.co.id";
	$config[4]["username"] = "cs@jalurkerja.co.id";
	$config[5]["username"] = "cs.jalurkerja@gmail.com";
	$config[6]["username"] = "cs@jalurkerja.net";
	$config[7]["username"] = "adminbroadcast@jalurkerja.com";
	$config[8]["username"] = "adminweb@jalurkerja.com";

	$config[1]["password"] = "";
	$config[2]["password"] = "dhovekhairassR2h2s12*";
	$config[3]["password"] = "dhovekhairassR2h2s12*";
	$config[4]["password"] = "dhovekhairassR2h2s12*";
	$config[5]["password"] = "R2h2s12*";
	$config[6]["password"] = "dhovekhairassR2h2s12*";
	$config[7]["password"] = "adminbroadcast11A";
	$config[8]["password"] = "adminweb11A";

	$mail             = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->SMTPDebug  = 0;
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = $config[$_server]["secure"];
	$mail->Host       = $config[$_server]["host"];
	$mail->Port       = $config[$_server]["port"];
	$mail->Username   = $config[$_server]["username"];
	$mail->Password   = $config[$_server]["password"];

	$mail->SMTPKeepAlive = true;  
	$mail->Mailer = "smtp"; 
	$mail->CharSet = 'utf-8';  
	$arr_replyto = explode("|",$replyto);
	$mail->SetFrom('cs@jalurkerja.com', 'Customer Service JalurKerja.com');
	$mail->AddReplyTo($arr_replyto[0],$arr_replyto[1]);
	$mail->Subject    = $subject;

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

	$mail->MsgHTML($body);

	$mail->AddAddress($address);

	if(!$mail->Send()) { return "0"; } else { gethttp_value("http://103.253.113.164/api/smtp_notes.php?mode=write&smtp_id=".$_server); return "1"; }
}
?>
