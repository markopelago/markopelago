<?php 
	include_once "../common.php";
	$model_album_id = $_GET["model_album_id"];
	$mode = $_GET["mode"];
	if($mode == 0) $mode == $__role;
	$album_id_fieldName = "album_id";
	if($mode == "3") $tableName = "agency_albums";
	if($mode == "4") {
		$tableName = "corporate_galleries";
		$album_id_fieldName = "gallery_id";
	}
	if($mode == "5") $tableName = "model_albums";
	$filename = $db->fetch_single_data($tableName,"filename",["id" => $model_album_id]);
	$album_id = $db->fetch_single_data($tableName,$album_id_fieldName,["id" => $model_album_id]);
	$next_id = $db->fetch_single_data($tableName,"id",[$album_id_fieldName => $album_id,"id"=>$model_album_id.":>"],["id"]);
	$prev_id = $db->fetch_single_data($tableName,"id",[$album_id_fieldName => $album_id,"id"=>$model_album_id.":<"],["id DESC"]);
	if(!$next_id) $next_id = $db->fetch_single_data($tableName,"id",[$album_id_fieldName => $album_id],["id"]);
	if(!$prev_id) $prev_id = $db->fetch_single_data($tableName,"id",[$album_id_fieldName => $album_id],["id DESC"]);
?>
<table>
	<tr>
		<td onclick="showGalery('<?=$prev_id;?>');" valign="middle" nowrap><i style="font-size:40px;" class="fa fa-arrow-left"></i></td>
		<td align="center" nowrap><img class="img-responsive" src="user_images/<?=$filename;?>" style="width:100%"></td>
		<td onclick="showGalery('<?=$next_id;?>');" valign="middle" align="right" nowrap><i style="font-size:40px;" class="fa fa-arrow-right"></i></td>
	</tr>
</table>