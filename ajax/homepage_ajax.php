<?php 
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	
	if($_mode == "signup"){ echo $js->signup($_GET["namalengkap"],str_replace(" ","",$_GET["email"]),$_GET["password"],$_GET["repassword"]); }
?>
