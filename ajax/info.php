<?php 
	include_once "../common.php";	
	$mode = $_GET["mode"];
	echo v($mode)."|||";
	echo $db->fetch_single_data("a_config",$mode,["id" => 1])."|||";
	echo "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">".v("close")."</button>";
?>