<?php
	set_time_limit(0);
	function resizeImage($filename){
		list($width, $height) = getimagesize($filename);
		echo " ==> ".$width;
		if($width > 900){
			// $percent = 1024/$width;
			$percent = 800/$width;
			$newwidth = $width * $percent;
			$newheight = $height * $percent;
			
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = imagecreatefromjpeg($filename);
			
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			imagejpeg($thumb, $filename,100);
			echo " : ".$newwidth;
		}
		return 1;
	}
	$d = dir(".");
	$no=0;
	while (false !== ($entry = $d->read())) {
		$ext = pathinfo($entry,PATHINFO_EXTENSION);
		if($ext == "jpg" || $ext == "png"){
			$no++;
			echo $no.". ".$entry;
			resizeImage($entry);
			echo "<br>";
		}
	}
	$d->close();
?>