<?php
	set_time_limit(0);
	
	include_once "../classes/database.php";
	
	$db = new Database();
	
	
	
	function read_file($filename){
		$fp = fopen($filename, "r");
		$return = @fread($fp,filesize($filename));
		fclose($fp);
		return $return;
	}
	
	function write_file($filename,$content,$mode = "w+"){
		$fp = fopen($filename, $mode);
		fwrite($fp, $content);
		fclose($fp);
	}
	
?>