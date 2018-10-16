<?php
	include_once "../common.php";
	include_once "user_info.php";
	include_once "func.photo_items.php";
	$data = file_get_contents('php://input');
	$site_id = $_GET["site_id"];
	$sitename = $_GET["sitename"];
	$photo_item_id = $_GET["photo_item_id"];
	$indottech_geotagging_req_id = $_GET["indottech_geotagging_req_id"];
	$sitename = $db->fetch_single_data("indottech_geotagging_req","sitename",["id" => $indottech_geotagging_req_id]);
	$photo_item_name = get_complete_name($photo_item_id);
	
	if($indottech_geotagging_req_id > 0){
		$tagging_at = $_GET["tagging_at"];
		$basefilename = "tag_".$user_id."_".$site_id."_".$tagging_at."_".$photo_item_name.".jpg";
		$basezipfile = "geotag_".$user_id."_".$site_id."_".$tagging_at.".zip";
		$filename = "../geophoto/".$basefilename;
		$zipfile = "../geophoto/".$basezipfile;
	}
	if($_GET["photoMode"] == "atp_installation_battery_photo"){
		$params = explode("|",$_GET["param"]);
		$fieldname = $params[0];
		$atd_id = $params[1];
		$battery_discharge_id = $params[2];
		$tagging_at = date("YmdHis");
		$basefilename = "tag_".$__user_id."_".$fieldname."_".$atd_id."_".$battery_discharge_id."_".$tagging_at.".jpg";
		$filename = "../geophoto/".$basefilename;
		$coordinates = explode("|",$_GET["coordinate"]);
		$latitude = $coordinates[0];
		$longitude = $coordinates[1];
		$site_id = $db->fetch_single_data("indottech_atd_cover","site_id",["id" => $atd_id]);
		$site_name = $db->fetch_single_data("indottech_atd_cover","site_name",["id" => $atd_id]);
		$battery_discharge_photos_id = $db->fetch_single_data("indottech_battery_discharge_photos","id",["battery_discharge_id" => $battery_discharge_id,"atd_id" => $atd_id,"minute_at" => "30"]);
		$oldfile = $db->fetch_single_data("indottech_battery_discharge_photos",$fieldname,["id" => $battery_discharge_photos_id]);
		unlink("../geophoto/".$oldfile);
	}
	if($_GET["photoMode"] == "atp_installation_photos_detail"){
		$params = explode("|",$_GET["param"]);
		$atd_id = $params[0];
		$photo_items_id = $params[1];
		$tagging_at = date("YmdHis");
		$basefilename = "tag_atp_installation_".$__user_id."_".$atd_id."_".$photo_items_id."_".$tagging_at.".jpg";
		$filename = "../geophoto/".$basefilename;
		$site_id = $db->fetch_single_data("indottech_atd_cover","site_id",["id" => $atd_id]);
		if($_GET["coordinate"] != ""){
			$coordinates = explode("|",$_GET["coordinate"]);
			$latitude = $coordinates[0];
			$longitude = $coordinates[1];			
		} else {
			$latitude = $db->fetch_single_data("indottech_sites","latitude",["id" => $site_id]);
			$longitude = $db->fetch_single_data("indottech_sites","longitude",["id" => $site_id]);
		}
		$site_name = $db->fetch_single_data("indottech_atd_cover","site_name",["id" => $atd_id]);
		$photo_title = $db->fetch_single_data("indottech_photo_items","name",["id" => $photo_items_id]);
		$seqno = $db->fetch_single_data("indottech_photos","seqno",["atd_id" => $atd_id,"photo_items_id" => $photo_items_id],["seqno DESC"]);
		$seqno++;
	}
	if($_GET["photoMode"] == "tag_photo_project_detail"){
		$params = explode("|",$_GET["param"]);
		$atd_id = $params[0];
		$photo_items_id = $params[1];
		$_site_id = $db->fetch_single_data("indottech_tag_photo_projects","site_id",["id" => $atd_id]);
		$site_id = $db->fetch_single_data("indottech_tag_photo_projects","site_code",["id" => $atd_id]);
		$doctype = $db->fetch_single_data("indottech_photo_items","doctype",["id" => $photo_items_id]);
		$com = $db->fetch_single_data("indottech_photo_items","com",["id" => $photo_items_id]);
		$seqno = $db->fetch_single_data("indottech_photos","seqno",["atd_id" => $atd_id,"photo_items_id" => $photo_items_id],["seqno DESC"]);
		$seqno++;
		$basefilename = $site_id."_".$com."_".$doctype.numberpad($seqno,2).".jpg";
		$filename = "../geophoto/".$basefilename;
		if($_GET["coordinate"] != ""){
			$coordinates = explode("|",$_GET["coordinate"]);
			$latitude = $coordinates[0];
			$longitude = $coordinates[1];			
		} else {
			$latitude = $db->fetch_single_data("indottech_sites","latitude",["id" => $_site_id]);
			$longitude = $db->fetch_single_data("indottech_sites","longitude",["id" => $_site_id]);
		}
		$site_name = $db->fetch_single_data("indottech_tag_photo_projects","site_name",["id" => $atd_id]);
		$photo_title = $db->fetch_single_data("indottech_photo_items","name",["id" => $photo_items_id]);
	}
	if($_GET["photoMode"] == "view_activities" || $_GET["photoMode"] == "attendance_sick"){
		$params = explode("|",$_GET["param"]);
		$plan_id = $params[0];
		$plan_site_id = $params[1];
		$basefilename = "activityphoto_".$__user_id."_".$plan_id."_".$plan_site_id.".jpg";
		$filename = "../geophoto/".$basefilename;
	}
	
	if (!(file_put_contents($filename,$data) === FALSE)){
		resizeImage($filename);
		if($indottech_geotagging_req_id > 0){
			$latitude = $db->fetch_single_data("indottech_geotagging_req","latitude",["id" => $indottech_geotagging_req_id]);
			$longitude = $db->fetch_single_data("indottech_geotagging_req","longitude",["id" => $indottech_geotagging_req_id]);
			$imgtext = $site_id." ".$sitename;
			$imgtext .= "<br>".$latitude.";".$longitude;
			$imgtext .= "<br>".date("Y/m/d H:i:s");
			insertTextImg($filename,$filename,$imgtext);
			
			$db->addtable("indottech_geotagging"); 
			$db->where("indottech_geotagging_req_id",$indottech_geotagging_req_id);
			$db->where("photo_item_id",$photo_item_id);
			$db->delete_();
			
			$db->addtable("indottech_geotagging");
			$db->addfield("indottech_geotagging_req_id");	$db->addvalue($indottech_geotagging_req_id);
			$db->addfield("user_id");						$db->addvalue($user_id);
			$db->addfield("site_id");						$db->addvalue($site_id);
			$db->addfield("sitename");						$db->addvalue($sitename);
			$db->addfield("tagging_at");					$db->addvalue($tagging_at);
			$db->addfield("photo_item_id");					$db->addvalue($photo_item_id);
			$db->addfield("filename");						$db->addvalue($basefilename);
			$db->addfield("created_at");					$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("created_by");					$db->addvalue($username);
			$db->addfield("created_ip");					$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->insert();
			$zip = new ZipArchive;
			if(true === ($zip->open($zipfile, ZipArchive::CREATE))){
				$zip->addFile($filename, $basefilename);
				$zip->close();
			}
			
			$photo_item_ids = pipetoarray($db->fetch_single_data("indottech_geotagging_req","photo_item_ids",["id" => $indottech_geotagging_req_id]));
			echo "File Transfered||".next_photo_item($photo_item_ids,$photo_item_id)."||".get_complete_name(next_photo_item($photo_item_ids,$photo_item_id));
		}
		if($_GET["photoMode"] == "atp_installation_battery_photo"){
			$imgtext = $site_id." - ".$site_name;
			$imgtext .= "<br>".$latitude.";".$longitude;
			$imgtext .= "<br>".date("d/m/Y H:i:s");
			insertTextImg($filename,$filename,$imgtext);
			
			$db->addtable("indottech_battery_discharge_photos");
			if($battery_discharge_photos_id > 0)	$db->where("id",$battery_discharge_photos_id);
			$db->addfield("battery_discharge_id");	$db->addvalue($battery_discharge_id);
			$db->addfield("atd_id");				$db->addvalue($atd_id);
			$db->addfield("minute_at");				$db->addvalue("30");
			$db->addfield($fieldname);				$db->addvalue($basefilename);
			if($battery_discharge_photos_id > 0) $db->update();
			else $db->insert();
			echo "OK";
		}
		if($_GET["photoMode"] == "atp_installation_photos_detail" || $_GET["photoMode"] == "tag_photo_project_detail"){
			$imgtext = $site_id." - ".$site_name;
			$imgtext .= "<br>".$latitude.";".$longitude;
			$imgtext .= "<br>".date("d/m/Y H:i:s");
			insertTextImg($filename,$filename,$imgtext);
			
			$db->addtable("indottech_photos");
			$db->addfield("atd_id");			$db->addvalue($atd_id);
			$db->addfield("photo_items_id");	$db->addvalue($photo_items_id);
			$db->addfield("photo_title");		$db->addvalue($photo_title);
			$db->addfield("filename");			$db->addvalue($basefilename);
			$db->addfield("seqno");				$db->addvalue($seqno);
			$db->insert();
			echo "OK";
		}
		if($_GET["photoMode"] == "view_activities" || $_GET["photoMode"] == "attendance_sick"){
			echo "OK";
		}
	} else {
		echo "File Failed Transfered||"; 
	}
?>
