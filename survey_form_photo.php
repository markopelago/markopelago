<?php
	if(isset($_GET["addcaption"])){
		$db->addtable("survey_photos");	$db->where("id",$_GET["survey_photo_id"]); $db->where("survey_id","(SELECT id FROM surveys WHERE user_id='".$__user_id."')","s","IN");
		$db->addfield("caption");	$db->addvalue($_GET["addcaption"]);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			$_SESSION["message"] = v("update_photo_caption_success");
		} else {
			$_SESSION["errormessage"] = v("update_photo_caption_failed");
		}
		javascript("window.location=\"?id=".$id."&step=photo\";");
	}
	if(isset($_GET["delete_id"])){
		$delete_seqno = $db->fetch_single_data("survey_photos","seqno",["id" => $_GET["delete_id"]]);
		$delete_filename = $db->fetch_single_data("survey_photos","filename",["id" => $_GET["delete_id"]]);
		$db->addtable("survey_photos"); $db->where("id",$_GET["delete_id"]); $db->where("survey_id","(SELECT id FROM surveys WHERE user_id='".$__user_id."')","s","IN");
		$db->delete_();
		$survey_photos = $db->fetch_all_data("survey_photos",[],"survey_id IN (SELECT id FROM surveys WHERE user_id='".$__user_id."') AND seqno > ".$delete_seqno);
		foreach($survey_photos as $survey_photo){
			$seqno = $survey_photo["seqno"] - 1;
			$db->addtable("survey_photos");	$db->where("id",$survey_photo["id"]);
			$db->addfield("seqno");	$db->addvalue($seqno);
			$db->update();
		}
		unlink("surveys/".$delete_filename);
		javascript("window.location=\"?id=".$id."&step=photo\";");
		exit();
	}
	
	if($_FILES["take_photo"]["size"] > 100 && $_FILES["take_photo"]["tmp_name"] != ""){
		$ext = strtolower(pathinfo($_FILES["take_photo"]["name"], PATHINFO_EXTENSION));
		$filename = randtoken(25)."_".$__user_id.".".$ext;
		$target_file = "surveys/".$filename;
		if(move_uploaded_file($_FILES["take_photo"]["tmp_name"], $target_file)){
			$seqno = $db->fetch_single_data("survey_photos","seqno",["survey_id" => $id],["seqno DESC"]);
			$seqno++;
			$db->addtable("survey_photos");
			$db->addfield("survey_id");	$db->addvalue($id);
			$db->addfield("seqno");		$db->addvalue($seqno);
			$db->addfield("filename");	$db->addvalue($filename);
			$db->insert();
		}
	}
?>
<script>
	$(document).ready(function () { $('#waterfall').NewWaterfall({width: 200}); });
	function update_caption(survey_photo_id,caption){
		window.location="?id=<?=$id;?>&step=photo&survey_photo_id="+survey_photo_id+"&addcaption="+caption;
	}
	function deleting_photo(delete_id){
		if(confirm("<?=v("are_you_sure_delete_photo");?>")) window.location="?id=<?=$id;?>&step=photo&delete_id="+delete_id;
	}
</script>
<form role="form" method="POST" autocomplete="off" enctype="multipart/form-data">
	<h4><b><?=v("upload_photo");?></b></h4>
	<div class="col-md-12">
		<div class="form-group">
			<input type="file" name="take_photo" id="take_photo" class="take-photo" onchange="submit();">
			<label for="take_photo"><figure><img src="icons/camera.png"></figure> <span><?=v("take_photo");?>&hellip;</span></label>
		</div>
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='?step=2&id=".$id."';\"","btn btn-warning");?>
			<?=$f->input("finish",v("finish"),"type='button' onclick=\"window.location='mysurvey.php';\" style='position:relative;float:right;'","btn btn-primary");?>
		</div>
	</div>
	<div class="col-md-12">
		<ul id="waterfall">
			<?php
				$survey_photos = $db->fetch_all_data("survey_photos",[],"survey_id='".$id."'","seqno");
				foreach($survey_photos as $survey_photo){
			?>
				<li>
					<div class="thumbnail">
						<a class="close" href="javascript:deleting_photo('<?=$survey_photo["id"];?>');">&times;</a>
						<img src="surveys/<?=$survey_photo["filename"];?>">
						<?=$f->input("caption[".$survey_photo["id"]."]",$survey_photo["caption"],"onblur='update_caption(\"".$survey_photo["id"]."\",this.value);'","form-control");?>
					</div>
				</li>
			<?php 
				} 
			?>
		</ul>
	</div>
</form>